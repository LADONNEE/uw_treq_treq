<?php
namespace App\Workflows;

class OrderType
{
    public $slug;
    public $name;
    public $icon;

    public function __construct($slug, $name, $icon)
    {
        $this->slug = $slug;
        $this->name = $name;
        $this->icon = $icon;
    }
}
