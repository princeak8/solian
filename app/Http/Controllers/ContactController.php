<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\Utility\CompanyService;

class ContactController extends Controller
{
    private $companyService;

    public function __construct()
    {
        $this->companyService = new CompanyService;
    }

    public function index()
    {
        $companyInfo = $this->companyService->companyInfo();
        return view('contact', compact('companyInfo'));
    }
}
