<?php
namespace App\Reports;

use App\Auth\User;
use Illuminate\Support\Facades\DB;
use Config;

class UsersReport
{

    private $table;

    public function __construct() {
            $this->table = Config::get('app.database_shared'); 
    } 

    public function getReport()
    {
        $results = DB::table('auth AS a')
            ->join($this->table . '.uw_persons AS p', 'a.uwnetid', '=', 'p.uwnetid')
            ->leftJoin('user_folders AS f', 'p.person_id', '=', 'f.person_id')
            ->select([
                'a.uwnetid',
                'a.role',
                'p.person_id',
                'p.firstname',
                'p.lastname',
                'f.url AS folder_url',
                'f.name AS folder_name'
            ])
            ->orderBy('p.lastname')
            ->orderBy('p.firstname')
            ->get();

        // transform results to single User -> array of roles
        $users = [];
        foreach ($results as $row) {
            if (isset($users[$row->uwnetid])) {
                $users[$row->uwnetid]->addRole($row->role);
            } else {
                $users[$row->uwnetid] = new User($row->uwnetid, $row);
                $users[$row->uwnetid]->addRole($row->role);
            }
        }

        return $users;
    }
}
