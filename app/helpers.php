<?php
use Illuminate\Support\Facades\Session;
use \App\Models\TeacherStudyType;
use \App\Models\Currency;
use Illuminate\Support\Arr;
use AmrShawky\LaravelCurrency\Facade\Currency as CurrencyConvertor;


if (! function_exists('convert_to_default_currency')) {
    function convert_to_default_currency($currency_id, $value) {
        
        $current_currency_symbol = env('DEFAULT_CURRENCY_SYMBOL');
        
        $all_currencies = session()->get('currencies');
        
        foreach($all_currencies as $currency) {
            if($currency['id'] == $currency_id) {
                $value = CurrencyConvertor::convert()->from($currency['symbol'])->to($current_currency_symbol)->amount($value)->get();
                return $value;
            }
        }
    }
}

if (! function_exists('convert_to_currency')) {
    function convert_to_currency($currency_id, $value) {

        $current_currency_symbol = Session::get('current_currency')['symbol'] ?? env('DEFAULT_CURRENCY_SYMBOL');
        
        $all_currencies = session()->get('currencies');
        
        foreach($all_currencies as $currency) {
            if($currency['id'] == $currency_id) {
                $value = CurrencyConvertor::convert()->from($currency['symbol'])->to($current_currency_symbol)->amount($value)->get();
                $value = number_format((float)$value, 2, '.', '');
                return $value . " " . $current_currency_symbol;
            }
        }
    }
}

if (! function_exists('get_min_fees')) {
    function get_min_fees($teacher_id) {
        $fees = TeacherStudyType::select('fees', 'currency_id')->where('teacher_id', $teacher_id)->get()->toArray();
        foreach($fees as $i => $fee) {
            $fees[$i]['fees'] = convert_to_currency($fee['currency_id'] , $fee['fees']);
        }
        if($fees) {
            return $fees = min(Arr::pluck($fees, 'fees'));
        } else {
            return $fees = 0;
        }
    }
}
