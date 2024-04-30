<?php

namespace App\Jobs\CMS;

use App\Exceptions\CMS\ActiveUserException;
use App\Models\CMS\CMSUser;

class ActivateUserInCorrespondenceManagementSystemJob extends CMSJob
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
            CMSUser::where('user_login', $customer->document)->limit(1)
                ->update(['user_url' => 'https://activate.oshi']);
        } catch (\Throwable $th) {
            throw new ActiveUserException('Erro ao ativar o usuário no CMS.', $th->getMessage(), ['document' => $customer->document]);
        }
    }
}
