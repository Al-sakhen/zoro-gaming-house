<?php

if (!function_exists('format_currency')) {
    /**
     * Format currency with JD suffix
     *
     * @param float|int $amount
     * @return string
     */
    function format_currency($amount)
    {
        return number_format($amount, 2) . ' JD';
    }
}
