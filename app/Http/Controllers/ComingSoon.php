<?php
namespace App\Http\Controllers;

class ComingSoon extends Controller
{
    public function __invoke()
    {
        \Log::debug('Test debug message');
        return view('coming-soon');
    }
}
