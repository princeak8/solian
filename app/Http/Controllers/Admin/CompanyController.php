<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Http\Requests\SaveBankAccountRequest;

use App\Services\Utility\CompanyService;

class CompanyController extends Controller
{
    private $companyService;

    public function __construct()
    {
        $this->middleware('adminAuth');
        $this->companyService = new CompanyService;
    }

    public function index()
    {
        try{
            $company = $this->companyService->companyInfo();
        } catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
        }
        return view('admin/company', compact('company'));
    }

    public function bank_account_form($id = null)
    {
        try{
            $bankAccountData = $this->companyService->bankAccountForm($id);
            //dd($productData['product']);
            if($id != null && !$bankAccountData['bankAccount']) return redirect('admin/bank_accounts')->with('error', 'Bank Account was not found');

            $title = $bankAccountData['title'];
            $bankAccount = $bankAccountData['bankAccount'];
            $banksData = $bankAccountData['banksData'];
            //dd($banksData);
            return view('admin/bank_account_form', compact('title', 'bankAccount', 'banksData'));
        } catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            return redirect('admin/bank_accounts')->with('error', $th->getMessage());
        }
    }

    public function save_account(SaveBankAccountRequest $request)
    {
        try{
            $id = $request->get('id');
            if($id==null) { 
                $this->companyService->addAccount($request->validated());
            }else{
                $data = $request->validated();
                $data['id'] = $id;
                $this->companyService->updateAccount($data);
            }
            return redirect('admin/bank_accounts');
        }catch(\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            return redirect('admin/bank_accounts')->with('error', $th->getMessage());
        }
    }

    public function update_account(SaveBankAccountRequest $request)
    {
        try{
            $id = $request->get('id');
            $data = $request->validated();
            $data['id'] = $id;
            $this->companyService->updateAccount($data);
            return redirect('admin/bank_accounts');
        }catch(\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            return redirect('admin/bank_accounts')->with('error', $th->getMessage());
        }
    }

    public function bank_accounts()
    {
        try{
            $bankAccounts = $this->companyService->bankAccounts();
        } catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
        }
        return view('admin/bank_accounts', compact('bankAccounts'));
    }

    public function toggle_activation(Request $request)
    {
        $post = $request->all();
        $validator = Validator::make($post, [
            'active' => 'required|integer',
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        try{
            $account = $this->companyService->bankAccount($post['id']);
            if($account) {
                $this->companyService->toggleAccountActivation($account, $post['active']);
                return response()->json([
                    'statusCode' => 200,
                    'message' => 'successfull operation'
                ], 200);
            }else{
                return response()->json([
                    'statusCode' => 404,
                    'message' => 'Bank Account not found'
                ], 404);
            }
        }catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            return response()->json([
                'statusCode' => 500,
                'message' => 'An error occured, please contact the Administrator'
            ], 500);
        }
    }
}
