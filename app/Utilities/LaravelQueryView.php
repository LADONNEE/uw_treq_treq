<?php
namespace App\Utilities;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class LaravelQueryView
{
    private $query;

    public function __construct($query = null)
    {
        $this->setQuery($query);
    }

    public function setQuery($query)
    {
        $this->query = $query;
    }

    public function getSql()
    {
        if (!$this->query instanceof QueryBuilder && !$this->query instanceof EloquentBuilder) {
            return '(query is not Laravel Query Builder)';
        }
        $template = $this->query->toSql();
        $bindings = $this->query->getBindings();
        return $this->replaceQuestionMarks($template, $bindings);
    }

    public function replaceQuestionMarks($string, array $values)
    {
        foreach ($values as $value) {
            $string = preg_replace('/\'.*?\'(*SKIP)(*FAIL)|\?/', $value, $string, 1);
        }
        return $string;
    }

}
