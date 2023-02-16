<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use \App\Models\Currency;

use \App\Http\Services\ParsingService;

class Localization
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }

        
        $currencies = ParsingService::parseCurrencies(Currency::get());
        Session::put('currencies' , $currencies);

        if(!Session::has('current_currency')) {
            Session::put('current_currency' , $currencies[0]);
        }

        return $next($request);
    }
}