<?php
namespace App\Http\Services;

class ParsingService {
    
    static function parseCurrencies($arr) {
        $res = [];

        foreach($arr as $item) {

            $res[] = [
                'id' => $item['id'],
                'name' => $item['name_' . app()->currentLocale()],
                'rate' => $item['rate'],
                'symbol' => $item['symbol']
            ];
        }

        return $res;
    }

    static function parseLanguages($arr) {
        $res = [];

        foreach($arr as $item) {
            $res[] = [
                'id' => $item['id'],
                'name' => $item['name_' . app()->currentLocale()],
            ];
        }

        return $res;
    }

    static function parseLanguagesLevels($arr) {
        $res = [];

        foreach($arr as $item) {
            $res[] = [
                'id' => $item['id'],
                'name' => $item['name_' . app()->currentLocale()],
            ];
        }

        return $res;
    }

    static function parseCountries($arr) {
        $res = [];

        foreach($arr as $item) {
            $res[] = [
                'id' => $item['id'],
                'name' => $item['name_' . app()->currentLocale()],
            ];
        }

        return $res;
    }

    static function parseLevels($arr) {
        $res = [];

        foreach($arr as $item) {
            $res[] = [
                'id' => $item['id'],
                'name' => $item['name_' . app()->currentLocale()],
            ];
        }

        return $res;
    }


    static function parseCurriculum($arr) {
        $res = [];

        foreach($arr as $item) {
            $res[] = [
                'id' => $item['id'],
                'name' => $item['name_' . app()->currentLocale()],
            ];
        }

        return $res;
    }
    
    static function parseTopics($arr) {
        $res = [];

        foreach($arr as $item) {
            $res[] = [
                'id' => $item['id'],
                'name' => $item['name_' . app()->currentLocale()],
                'parent' => $item['parent'],
                'image' => $item['image']
            ];
        }

        return $res;
    }

}