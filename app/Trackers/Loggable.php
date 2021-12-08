<?php
namespace App\Trackers;

interface Loggable
{
    public function isEmpty(): bool;
    public function getMessage(): string;
}
