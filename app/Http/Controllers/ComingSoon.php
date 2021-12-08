<?php
namespace App\Http\Controllers;

class ComingSoon extends Controller
{
    public function __invoke()
    {
        return view('coming-soon');
    }
}
