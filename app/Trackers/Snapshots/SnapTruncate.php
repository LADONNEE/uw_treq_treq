<?php
namespace App\Trackers\Snapshots;

use App\Utilities\FirstWords;

class SnapTruncate extends SnapField
{
    private $length;
    protected static $firstWords;

    public function __construct($value, $length = 30)
    {
        parent::__construct($value);
        $this->length = $length;
    }

    public function format()
    {
        if (!$this->value || strlen($this->value) <= $this->length) {
            return $this->value;
        }

        if (self::$firstWords === null) {
            self::$firstWords = new FirstWords();
        }

        return self::$firstWords->getFirstWords($this->value, $this->length);
    }
}
