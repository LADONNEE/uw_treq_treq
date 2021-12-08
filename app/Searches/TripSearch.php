<?php
namespace App\Searches;


use App\Models\Trip;

class TripSearch
{
    protected $words;

    public function __construct(array $words)
    {
        $this->words = $words;
    }

    public function search()
    {
        $query = Trip::select('trips.*')
            ->join('projects', 'trips.project_id', '=', 'projects.id')
            ->orderBy('projects.created_at', 'desc')
            ->with('project');
        $this->addFilters($query);
        return $query->get();
    }

    public function addFilters($query)
    {
        foreach ($this->words as $word) {
            $query->where(function($query) use($word){
                $query->orWhere('trips.destination', 'like', "%{$word}%");
                $query->orWhere('trips.traveler', 'like', "%{$word}%");
                $query->orWhere('trips.traveler_email', 'like', $word . '%');
            });
        }
    }

}
