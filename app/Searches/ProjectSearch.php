<?php

namespace App\Searches;

use App\Models\Project;

class ProjectSearch
{
    protected $words;

    public function __construct(array $words)
    {
        $this->words = $words;
    }

    public function search()
    {
        $query = Project::orderBy('projects.created_at', 'desc');
        $this->addFilters($query);
        return $query->get();
    }

    public function addFilters($query)
    {
        foreach ($this->words as $word) {
            $query->where('projects.title', 'like', "%{$word}%");
            $num = $this->asNumber($word);
            if ($num) {
                $query->orWhere('projects.id', $num);
            }
        }
    }

    private function asNumber($word)
    {
        if (is_numeric($word)) {
            return (int) $word;
        }
        if (preg_match('/^treq\d+/', $word)) {
            return (int) substr($word, 4);
        }
        return null;
    }
}
