<?php

namespace App\Jobs;

use App\Dtos\CompanyOshi;
use App\Dtos\Customer\CustomerOshi;
use App\Exceptions\CreateException;
use App\Exceptions\UpdateException;
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
        /** Enviando o cliente para o ASAAS */
        $customerToUpdate = $this->sendCustomer($this->purchase);

        /**
         * Só cadastrar o cliente e a empresa se conseguirmos enviar o cliente para o ASAAS
         */
        try {
            DB::beginTransaction();

            $customerOshi = new CustomerOshi((object) $this->purchase);

            // Cadastro do cliente
            $customerOshi->sku = $customerToUpdate->sku;
            $customer = Customer::create((array) $customerOshi);

            // Cadastrando a empresa
            $customerOshi->company->owner_id = $customer->id;
            Company::create((array) $customerOshi->company);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new CreateException('Erro ao criar o cliente', $th->getMessage());
        }

        CreateBillingJob::dispatch(
            new AsaasBilling($customer)
        );
    }

    private function sendCustomer($purchase): object
    {
        return $this->bankingService->createCustomer(
            new AsaasCustomer((object) $purchase)
        );
    }
}
