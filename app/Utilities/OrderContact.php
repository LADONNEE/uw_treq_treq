<?php

namespace App\Utilities;

use Illuminate\Support\Facades\DB;
use Config;

class OrderContact
{
    public $fiscal_person_id;
    public $business_person_id;
    private $table;

    public function __construct($fiscal_person_id, $business_person_id)
    {
        $this->fiscal_person_id = $fiscal_person_id;
        $this->business_person_id = $business_person_id;
        $this->table = Config::get('app.database_shared'); 
    }

    /**
     * Return Order contacts prioritized by budget split type, split amount, created
     * @param int $order_id
     * @return OrderContact[]
     */
    public static function byOrder($order_id)
    {
        $biennium = setting('current-biennium');

        $resultsProjectCodes = DB::table('budgets AS b')
            ->select(['pc.authorizer_person_id', 'pc.fiscal_person_id'])
            ->join( Config::get('app.database_shared') . '.project_codes AS pc', 'b.project_code_id', '=', 'pc.id')
            ->where('b.order_id', $order_id)
            ->orderBy('b.split_type', 'desc') // R => Remainder, P => Percentage, A => Dollar Amount
            ->orderBy('b.split', 'desc')
            ->orderBy('b.created_at', 'desc')
            ->get();

        $results = DB::table('budgets AS b')
            ->select(['bc.fiscal_person_id', 'bc.business_person_id'])
            ->join( Config::get('app.database_shared') . '.budgets AS bc', function($join) use($biennium) {
                $join->on('b.budgetno', '=', 'bc.budgetno')
                    ->where('bc.biennium', $biennium);
            })
            ->where('b.order_id', $order_id)
            ->orderBy('b.split_type', 'desc') // R => Remainder, P => Percentage, A => Dollar Amount
            ->orderBy('b.split', 'desc')
            ->orderBy('b.created_at', 'desc')
            ->get();

        $out = [];

        
        foreach ($resultsProjectCodes as $row) {
            $out[] = new self($row->fiscal_person_id, $row->authorizer_person_id);
        }

        foreach ($results as $row) {
            $out[] = new self($row->fiscal_person_id, $row->business_person_id);
        }
        return $out;
    }
}
