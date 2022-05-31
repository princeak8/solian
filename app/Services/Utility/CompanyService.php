<?php

namespace App\Services\Utility;

use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
//use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use App\Helpers\Helper;
use Cloudinary;

use App\Services\Utility\UtilityService;

use App\Models\Company;
use App\Models\Company_account;

class CompanyService
{

    public static function companyInfo()
    {
        return Company::first();
    }

    public function bankAccounts()
    {
        return Company_account::all();
    }

    public function activeBankAccounts()
    {
        return Company_account::where('active', 1)->get();
    }

    public function bankAccount($id=null)
    {
        return ($id==null) ? new Company_account : Company_account::find($id);
    }

    public function addAccount($data)
    {
        Company_account::create($data);
    }

    public function updateAccount($data)
    {
        $account = $this->bankAccount($data['id']);

        $account->name = $data['name'];
        $account->number = $data['number'];
        $account->bank_id = $data['bank_id'];
        $account->update();
    }

    public function bankAccountForm($id)
    {
        $banksData = [];
        $title = 'Add a new Bank Account';
        $bankAccount = $this->bankAccount($id);
        if ($id != null) {
            $title = 'Edit Bank Account';
        }
        $banks = UtilityService::Banks();
        foreach($banks as $bank) {
            $banksData[$bank->id] = $bank->name;
        }
        return  [
                    'bankAccount' => $bankAccount,
                    'banksData' => $banksData,
                    'title' => $title
                ];
    }

    public function toggleAccountActivation($account, $active)
    {
        $account->active = $active;
        $account->update();
    }
}

?>