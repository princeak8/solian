<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

use App\Services\Product\CollectionService;

class PublicComposer
{
    private $collectionService;

    public function __construct()
    {
        //$this->currencies = Currency::all();
        $this->collectionService = new CollectionService;
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('collections', $this->collectionService->collections())->with('newArrivals', $this->collectionService->newArrivals());
    }
}

?>