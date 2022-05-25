<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

use App\Services\Product\CollectionService;
use App\Services\Utility\CurrencyService;

class PublicComposer
{
    private $collectionService;
    private $currencyService;

    private $collections;
    private $newArrivals;
    private $currencies;
    private $baseCurrency;
    private $rate;

    public function __construct()
    {
        //$this->currencies = Currency::all();
        $this->collectionService = new CollectionService;
        $this->currencyService = new CurrencyService;

        $this->collections = $this->collectionService->collections();
        $this->newArrivals = $this->collectionService->newArrivals();
        $this->currencies = $this->currencyService->currencies();
        $this->baseCurrency = $this->currencyService->baseCurrency();
        $this->rate = $this->currencyService->rate();
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('collections', $this->collections)
        ->with('newArrivals', $this->newArrivals)
        ->with('currencies', $this->currencies)
        ->with('baseCurrency', $this->baseCurrency)
        ->with('rate', $this->rate);
    }
}

?>