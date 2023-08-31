<?php
namespace App\Models;


/**
 * @property integer  $worktag_id
 * @property string   $wd_costcenter
 * @property string   $name
 * @property integer  $fiscal_person_id
 */

class WorktagLookup extends ReadOnlyModel
{
    protected $table;
  
    public function __construct() {
        $this->table = config('app.database_shared') . '.worktags'; 
    }

    protected $primaryKey = 'worktag_id';

}
