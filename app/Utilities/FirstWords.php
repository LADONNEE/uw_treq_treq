<?php

namespace App\Utilities;

class FirstWords
{
    public function getFirstWords($string, $length)
    {
        $partial = preg_replace('/\s\s+/', ' ', $string);
        $regex = "/^.{1,{$length}}\b/s";
        $matches = [];
        if (preg_match($regex, $partial, $matches)) {
            $partial = trim($matches[0]);
            if (strlen($partial) < strlen($string)) {
                $partial = "{$partial}...";
            } else {
                $partial = $string;
            }
        }
        return $partial;
    }
}
