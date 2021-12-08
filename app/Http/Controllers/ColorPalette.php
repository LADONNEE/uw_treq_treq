<?php
namespace App\Http\Controllers;

class ColorPalette
{
    public function __invoke()
    {
        $colors = ['gray', 'red', 'orange', 'yellow', 'green', 'teal', 'blue', 'indigo', 'purple', 'pink'];
        $ranks = [ 100, 200, 300, 400, 500, 600, 700, 800, 900 ];
        return view('home.colors', compact('colors', 'ranks'));
    }
}
