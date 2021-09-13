<?php

if (!function_exists('create4DigitCode')) {
    /**
     * @return int
     */
    function create4DigitCode(): int
    {
        return rand(1000, 9999);
    }
}
