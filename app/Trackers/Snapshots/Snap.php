<?php
namespace App\Trackers\Snapshots;

/**
 * Factories for SnapField implementations.
 * These strategies take Model properties and convert to strings that are human friendly.
 */
class Snap
{
    public static function date($value)
    {
        return new SnapDate($value);
    }

    public static function time($value)
    {
        return new SnapTime($value);
    }

    public static function text($value)
    {
        return new SnapField($value);
    }

    public static function truncate($value, $length = 30)
    {
        return new SnapTruncate($value, $length);
    }

    public static function yesNo($value)
    {
        return new SnapYesNo($value);
    }

    public static function personId($value)
    {
        return new SnapPerson($value);
    }
}
