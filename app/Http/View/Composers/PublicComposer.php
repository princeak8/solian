<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

use App\Models\Currency;
use App\Models\Currency_rate;
use App\Models\Collection;

class PublicComposer
{
    protected $currencies;
    protected $collections;

    public function __construct()
    {
        //$this->currencies = Currency::all();
        $this->collections = Collection::where('deleted', '0')->orderBy('created_at', 'desc')->get();
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('collections', $this->collections);
    }
}

?>