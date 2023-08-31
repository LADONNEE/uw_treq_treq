<?php
namespace App\Models;


/**
 * @property integer   $budget_id
 * @property string    $biennium
 * @property string    $budgetno
 * @property string    $edw_budgetno
 * @property string    $name
 * @property string    $name_pi
 * @property integer   $pi_person_id
 * @property integer   $fiscal_person_id
 */
class ProjectCodeLookup extends ReadOnlyModel
{
    
    protected $table;

    public function __construct() {
            $this->table = config('app.database_shared') . '.project_codes'; 
    } 

    protected $primaryKey = 'id';

}
