<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Services\Order\OrderService;
use App\Services\Payment\PaymentService;

use App\Http\View\Composers\ProjectComposer;
use App\Http\View\Composers\PublicComposer;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    private $orderService;
    private $paymentService;

    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['layouts.admin.sidebar', 'layouts.admin.header', 'admin.index'], ProjectComposer::class);
        View::composer(['layouts.public.sidenav'], PublicComposer::class);
    }
}
