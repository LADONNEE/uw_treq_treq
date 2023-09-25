<?php
namespace App\Models;

use App\Utilities\OneDriveName;
use Carbon\Carbon;

/**
 * @property integer  $id
 * @property integer  $person_id
 * @property string   $url
 * @property string   $name
 * @property integer  $created_by
 * @property Carbon   $created_at
 * @property Carbon   $updated_at
 *
 * ----------   Relationships   ----------
 */
class UserFolder extends Model
{
    protected $table = 'user_folders';
    protected $fillable = [
        'person_id',
        'url',
        'name',
        'created_by',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function generateShortName()
    {
        if ($this->url) {
            $this->name = (new OneDriveName())->name($this->url);
        } else {
            $this->name = '';
        }
    }

    public function setUrlAttribute($value)
    {
        if ($value !== $this->url) {
            $this->attributes['url'] = strtolower($value);
            $this->generateShortName();
        }
    }
}
