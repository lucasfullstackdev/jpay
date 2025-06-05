<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("create view vw_affiliate_subscriptions as
                SELECT result.affiliate_email,
                JSON_OBJECT(
                    'code', result.affiliate_code,
                    'name', result.affiliate_name,
                    'email', result.affiliate_email
                ) AS affiliate,
                JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'customer', result.customer,
                        'subscription', result.subscription,
                        'payment', JSON_OBJECT(
                            'paid', result.paid,
                            'cycle', result.cycle,
                            'value', result.value,
                            'method', result.billing_type,
                            'voucher', result.voucher_code,
                            'commission', JSON_OBJECT(
                                'value', IF(result.paid = true, result.affiliate_value, 0),
                                'percentage', result.affiliate_percentage
                            )
                        )
                    )
                ) AS billings,
                COUNT(result.customer) AS quantity_of_billings,
                SUM(result.value) AS total_sales,
                SUM(IF(result.paid = true, result.affiliate_value, 0)) AS total_commission
            FROM (
                SELECT
                    subquery.sku as subscription,
                    subquery.affiliate_code,
                    subquery.affiliate_name,
                    subquery.affiliate_email,
                    subquery.customer,
                    subquery.cycle,
                    subquery.billing_type,
                    subquery.voucher_code,
                    subquery.paid,
                    subquery.value,
                    subquery.affiliate_percentage,
                    subquery.affiliate_value
                FROM (
                    SELECT
                        s.*,
                        v.affiliate_percentage,
                        a.name AS affiliate_name,
                        a.email AS affiliate_email,
                        (
                            SELECT COUNT(1)
                            FROM billing_monitoring bm
                            WHERE bm.subscription_id = s.sku
                            AND bm.event IN ('PAYMENT_CREATED', 'PAYMENT_RECEIVED')
                            AND YEAR(bm.created_at) = YEAR(NOW())
                            AND MONTH(bm.created_at) = MONTH(NOW())
                        ) AS quantity_of_events,
                        (CASE 
                            WHEN (
                                SELECT COUNT(1)
                                FROM billing_monitoring bm
                                WHERE bm.subscription_id = s.sku
                                AND bm.event IN ('PAYMENT_CREATED', 'PAYMENT_RECEIVED')
                                AND YEAR(bm.created_at) = YEAR(NOW())
                                AND MONTH(bm.created_at) = MONTH(NOW())
                            ) = 2 THEN TRUE
                            ELSE FALSE
                        END) AS paid,
                        ROUND(s.value * (v.affiliate_percentage / 100), 2) AS affiliate_value
                    FROM
                        subscriptions s
                        JOIN vouchers v ON v.code = s.voucher_code
                        JOIN affiliates a ON a.slug = s.affiliate_code
                        JOIN affiliate_vouchers av ON av.affiliate_id = a.id AND av.voucher = v.code
                    WHERE
                        s.voucher_code IS NOT NULL
                        AND s.affiliate_code IS NOT NULL
                        AND a.active = TRUE
                        AND a.email IS NOT NULL
                ) AS subquery
                WHERE subquery.quantity_of_events > 0
            ) AS result
            GROUP BY result.affiliate_code, result.affiliate_name, result.affiliate_email;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('drop view vw_affiliate_subscriptions');
    }
};
