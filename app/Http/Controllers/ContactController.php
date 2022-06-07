<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactMessageRequest;

use App\Services\Utility\CompanyService;
use App\Services\MessageService;

use Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    private $companyService;
    private $messageService;

    public function __construct()
    {
        $this->companyService = new CompanyService;
        $this->messageService = new MessageService;
    }

    public function index()
    {
        $companyInfo = $this->companyService->companyInfo();
        return view('contact', compact('companyInfo'));
    }

    public function save_message(ContactMessageRequest $request)
    {
        try{
            $message = $this->messageService->save($request->validated());
            try{
                Mail::to('akalodave@gmail')->send(new ContactMail($message));
            } catch(\Exception $e) {
                //echo 'error';
            }
            return redirect('contact')->with('msg', 'Your message has been received successfully');
        }catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            return redirect('contact')->with('error', $th->getMessage());
        }
    }

    public function refreshCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
}
