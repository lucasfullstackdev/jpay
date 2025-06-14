<?php

namespace App\Http\Requests;

use App\Enums\Payment\PaymentCycle;
use App\Enums\Payment\PaymentMethod;
use App\Enums\Payment\PaymentType;
use App\Enums\Person;
use Illuminate\Validation\Rule;

class Purchase extends BaseRequest
{

    public function authorize(): bool
    {
        /** Se não tiver o segredo, abortar */
        if (empty($this->secret)) {
            return false;
        }

        /** Se o segredo for diferente do esperado, abortar */
        if ($this->secret != env('LANDING_PAGE_SECRET')) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            # Dados do cliente
            'customer.name'         => 'required|string|regex:/^\pL+(\s+\pL+)+$/u',
            'customer.email'        => 'required|string|email:rfc,dns',
            'customer.document'     => 'required|string|min:11|max:11',
            'customer.phone'        => 'required|string|max:20',
            'customer.street'       => 'required|string',
            'customer.number'       => 'required|string',
            'customer.neighborhood' => 'required|string',
            'customer.city'         => 'required|string',
            'customer.state'        => 'required|string',
            'customer.country'      => 'required|string',
            'customer.postal_code'  => 'required|string|min:8|max:8',
            'customer.complement'   => 'nullable|string',
            'customer.person'       => [
                'required',
                'string',
                Rule::in(Person::getValues()),
            ],

            # Dados da empresa
            'company.document'     => 'nullable|required_if:customer.person,PJ|string',
            'company.name'         => 'nullable|required_if:customer.person,PJ|string',
            'company.street'       => 'nullable|required_if:customer.person,PJ|string',
            'company.number'       => 'nullable|required_if:customer.person,PJ|string',
            'company.neighborhood' => 'nullable|required_if:customer.person,PJ|string',
            'company.city'         => 'nullable|required_if:customer.person,PJ|string',
            'company.state'        => 'nullable|required_if:customer.person,PJ|string',
            'company.country'      => 'nullable|required_if:customer.person,PJ|string',
            'company.postal_code'  => 'nullable|required_if:customer.person,PJ|string|min:8|max:8',
            'company.complement'   => 'nullable|string',

            # Dados da Cobrança
            'payment.method' => [
                'required',
                'string',
                Rule::in(PaymentMethod::getValues()),
                // function ($attribute, $value, $fail) {
                //     if ($value == PaymentMethod::BOLETO->value && $this->input('payment.cycle') != PaymentCycle::YEARLY->value) {
                //         $fail('Boleto só pode ser gerado para pagamento anual');
                //     }
                // },
                // function ($attribute, $value, $fail) {
                //     if ($value == PaymentMethod::UNDEFINED->value && !in_array($this->input('payment.cycle'), [PaymentCycle::SEMIANNUALLY->value, PaymentCycle::MONTHLY->value])) {
                //         $fail('Para método de pagamento indefinido, o ciclo de pagamento deve ser anual ou semestral');
                //     }
                // },
            ],
            'payment.cycle'  => ['required', 'string', Rule::in(PaymentCycle::getValues())],
        ];
    }
}
