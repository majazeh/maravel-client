<?php
namespace App;

use Symfony\Component\HttpFoundation\Cookie;

class Mobile {
    public static function parse($value, $parameters = null)
    {
        $country_codes = [
            'ir' => '98',
            'iq' => '964'
        ];
        $mobile_codes = [
            'ir' => [
                '90', '91', '92', '93', '99'
            ],
            'iq' => [
                '73', '74', '75', '76', '77', '78', '79'
            ]
        ];
        $mobile_country = null;
        $country = isset($parameters[0]) ? $parameters[0] : '*';
        if (!$country == '*' && !in_array($country, ['ir', 'iq'])) {
            return false;
        }
        if (substr($value, 0, 2) === '00' || substr($value, 0, 1) === '+') {
            if (substr($value, 0, 2) === '00') {
                $value = substr($value, 2);
            } else {
                $value = substr($value, 1);
            }
            foreach ($country_codes as $key => $code) {
                if (substr($value, 0, strlen($code)) == $code) {
                    $value = substr($value, strlen($code));
                    $mobile_country = $key;
                    break;
                }
            }
            if (!$mobile_country) {
                return false;
            }
        } elseif (substr($value, 0, 1) === '0') {
            $value = substr($value, 1);
        } elseif (strlen($value) > 10) {
            foreach ($country_codes as $key => $code) {
                if (substr($value, 0, strlen($code)) == $code) {
                    $value = substr($value, strlen($code));
                    $mobile_country = $key;
                    break;
                }
            }
            if (!$mobile_country) {
                return false;
            }
        }

        if (strlen($value) != 10) {
            return false;
        }
        foreach ($mobile_codes as $key => $codes) {
            $code = substr($value, 0, 2);
            if (in_array($code, $codes)) {
                if ($mobile_country == $key || !$mobile_country) {
                    $mobile_country = $key;
                    break;
                } else {
                    return false;
                }
            }
        }
        return [$value, $mobile_country, $country_codes[$mobile_country]];
    }
}

