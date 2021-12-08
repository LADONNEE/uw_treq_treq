<?php
namespace App\Http\Controllers;

use App\Api\AribaApi;
use App\Models\Ariba;
use App\Models\Order;
use App\Trackers\LoggedAriba;

class AribaApiController extends Controller
{
    public function index(Order $order)
    {
        $api = new AribaApi($order->aribas);
        return response()->json($api->items);
    }

    public function store(Order $order)
    {
        $ariba = new Ariba(['order_id' => $order->id]);
        $this->save($ariba);

        return $this->index($order);
    }

    public function update(Order $order, Ariba $ariba)
    {
        if (request('_action') === 'delete') {
            $cmd = new LoggedAriba($ariba, user()->person_id, []);
            $cmd->delete();
        } elseif (request('ref')) {
            $this->save($ariba);
        }

        return $this->index($order);
    }

    private function save(Ariba $ariba)
    {
        $patch = [
            'ref' => substr(request('ref'), 0, 100),
            'description' => substr(request('description'), 0, 200),
            'created_by' => user()->person_id,
        ];
        $cmd = new LoggedAriba($ariba, user()->person_id, $patch);
        $cmd->execute();
    }
}
