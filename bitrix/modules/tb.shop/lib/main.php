<?php

namespace Tb\Shop;

class Main
{

    // $forms = ['арбуз', 'арбуза', 'арбузов'];
    static function pluralForm($n, $forms)
    {
        return $n % 10 == 1 && $n % 100 != 11 ? $forms[0] : ($n % 10 >= 2 && $n % 10 <= 4 && ($n % 100 < 10 || $n % 100 >= 20) ? $forms[1] : $forms[2]);
    }

}
