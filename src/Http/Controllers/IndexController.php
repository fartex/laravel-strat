<?php

namespace Fartex\Strat\Http\Controllers;

use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): View
    {
        return view('strat::app');
    }
}
