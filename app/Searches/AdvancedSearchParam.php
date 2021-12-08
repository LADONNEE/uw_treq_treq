<?php

namespace App\Searches;

/**
 * Hold state for a single Advanced Search parameter and modify the query object
 */
class AdvancedSearchParam
{
    public $inputName;
    public $column;
    public $value;
    public $operator;
    public $type;

    public function __construct($inputName, $value, $operator, $column, $type)
    {
        $this->inputName = $inputName;
        $this->value = $value;
        $this->operator = $operator;
        $this->column = $column;
        $this->type = $type;
    }

    public function addFilter($query)
    {
        switch ($this->type) {
            case 'wildcard':
                $queryValue = "%{$this->value}%";
                break;
            case 'date':
            case 'exact':
            default:
                $queryValue = $this->value;
                break;
        }
        if (is_array($this->column)) {
            $this->searchMultipleColumns($query, $this->column, $this->operator, $queryValue);
        } else {
            $query->where($this->column, $this->operator, $queryValue);
        }
    }

    /**
     * Add a parethesized subquery that searches for a parameter value in multiple columns with OR logic
     * @param mixed $query
     * @param array $columns
     * @param mixed $operator
     * @param mixed $value
     */
    private function searchMultipleColumns($query, array $columns, $operator, $value)
    {
        $query->where(function() use($query, $columns, $operator, $value) {
            $query->where($columns[0], $operator, $value);
            for ($i = 1; $i < count($columns); ++ $i) {
                $query->orWhere($columns[$i], $operator, $value);
            }
        });
    }
}