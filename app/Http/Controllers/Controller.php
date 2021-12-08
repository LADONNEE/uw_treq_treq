<?php
namespace App\Http\Controllers;

use App\Exceptions\OrderLockedException;
use App\Models\Order;
use App\Workflows\CanIEdit;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    /**
     * If current user does not have $role abort response with 403 Not Authorized
     * @param string $role
     */
    public function authorize($role)
    {
        if (!hasRole($role)) {
            abort(403);
        }
    }

    /**
     * If user can not currently change $field abort response with 403 Not Authorized
     * @param Order $order
     * @param $field
     */
    public function canIEdit(Order $order, $field)
    {
        $canIEdit = new CanIEdit($order, user());
        if (!isset($canIEdit->{$field}) || !$canIEdit->{$field}) {
            throw new OrderLockedException($order, $field);
        }
    }

    /**
     * Store a message to be displayed on next page viewed by user
     * Optional args are string style (Bootstrap alert styles) and an Order object
     * @param string $message
     * @param mixed ...$args
     */
    public function flash($message, ...$args)
    {
        (new \App\Utilities\FlashMessage())->store($message, ...$args);
    }
}
