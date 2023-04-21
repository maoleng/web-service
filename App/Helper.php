<?php

if (! function_exists('prettyMoney')) {
    function prettyMoney($money): string
    {
        return number_format($money, 0, '', ',');
    }
}
