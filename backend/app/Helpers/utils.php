<?php

if (!function_exists('formatMessages')) {
    function formatMessages($messages): array {
        $formatMsg = [];
        foreach ($messages as $value) {
            $formatMsg = array_merge($formatMsg, $value);
        }
        return $formatMsg;
    }
}
