<?php

namespace App\Jobs;

use App\Dtos\CompanyOshi;
use App\Dtos\Customer\CustomerOshi;
use App\Http\Requests\Purchase;
use App\Models\Company;
use App\Models\Customer;
use App\Services\Banking\Asaas\AsaasBilling;
use App\Services\Banking\Asaas\AsaasCustomer;
use App\Services\Banking\BankingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateExternalCustomerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private BankingService $bankingService;

    /**
     * Create a new job instance.
     */
    public function __construct(public $purchase)
    {
        $this->bankingService = new BankingService();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /**
         * Aqui devemos seguir a seguinte linha de raciocínio:
         * - Antes de enviar para o ASAAS precisamos garantir que do nosso lado está salvo direitinho
         * - Se o ASAAS não conseguir salvar, então executar o rollback
         */
        try {
            $customerOshi = new CustomerOshi((object) $this->purchase);

            /**
             * Inserindo customer e company com os valores base,
             * após enviar para o ASAAS iremos atualizar com informações complementares
             */
            DB::beginTransaction();
            $customer = Customer::create((array) $customerOshi);
            $customerOshi->company->owner_id = $customer->id;
            $company = Company::create((array) $customerOshi->company);
            DB::commit();

            /** Enviando o cliente para o ASAAS */
            $customerToUpdate = $this->sendCustomer($this->purchase);

            /** Atualizando com os dados retornados pelo ASAAS */
            DB::beginTransaction();
            $customer->sku = $customerToUpdate->sku;
            $customer->save();

            $company->city = $customerToUpdate->company->city;
            $company->state = $customerToUpdate->company->state;
            $company->country = $customerToUpdate->company->country;
            $company->save();
            DB::commit();
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    private function sendCustomer($purchase): object
    {
        return $this->bankingService->createCustomer(
            new AsaasCustomer((object) $purchase)
        );
    }
}
