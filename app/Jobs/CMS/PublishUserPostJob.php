<?php

namespace App\Jobs\CMS;

use App\Enums\CMS\CMSPostStatus;
use App\Enums\CMS\CMSPostType;
use App\Exceptions\CMS\PublishUserPostException;
use App\Models\CMS\CMSPost;

class PublishUserPostJob extends CMSJob
{
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Verificar se o cliente existe
        $customer = $this->getCustomer();
        if (empty($customer)) {
            return;
        }

        try {
            CMSPost::where([
                'post_type' => CMSPostType::CLIENTE_DOMICILIO->value,
                'post_title' => $customer->email,
                'post_status' => CMSPostStatus::DRAFT->value,
            ])->limit(1)
                ->update(['post_status' => CMSPostStatus::PUBLISH->value]);
        } catch (\Throwable $th) {
            throw new PublishUserPostException('Erro ao public POST do usuário no CMS.', '$th->getMessage()', ['email' => $customer->email]);
        }
    }
}
