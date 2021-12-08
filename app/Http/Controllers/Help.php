<?php
namespace App\Http\Controllers;

class Help extends Controller
{
    public function __invoke($slug)
    {
        $viewScript = resource_path() . "/views/help/{$slug}.blade.php";
        if (!file_exists($viewScript)) {
            abort(404);
        }
        return view("help.{$slug}");
    }
}
