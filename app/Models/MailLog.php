<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * @property integer $id
 * @property integer $order_id
 * @property string $mailable
 * @property string $email
 * @property Carbon $attempted_at
 * @property string $result
 * @property string $metadata
 * @property string $error
 */
class MailLog extends Model
{
    protected $table = 'mail_logs';
    protected $fillable = [
        'order_id',
        'mailable',
        'email',
        'attempted_at',
        'result',
        'metadata',
        'error',
    ];
    protected $dates = [
        'attempted_at',
        'sent_at',
    ];
    public $timestamps = false;

    public function setMetadata($data)
    {
        foreach ($data as $key => $value) {
            if (in_array($key, $this->fillable)) {
                $this->{$key} = $value;
                unset($data[$key]);
            }
        }
        $this->metadata = json_encode($data);
    }
}
