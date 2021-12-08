<?php
namespace App\Utilities;

use App\Auth\User;
use App\Models\AuthLog;
use App\Models\UserAuth;
use Illuminate\Support\Facades\DB;

class UserImporter
{
    const MIN_AUTH_ROLE = 'treq:user';
    protected $uwnetid;

    public function __construct($uwnetid)
    {
        $this->uwnetid = $uwnetid;
    }

    public function authorize()
    {
        if ($this->hasUwnetid() && $this->needsAuthorization() && $this->canAuthorize()) {
            $auth = new UserAuth();
            $auth->save($this->uwnetid, [ self::MIN_AUTH_ROLE ]);

            $log = new AuthLog([
                'uwnetid' => $this->uwnetid,
                'actor_id' => user()->person_id,
            ]);
            $log->message = 'authorized by approval request as ' . self::MIN_AUTH_ROLE;
            $log->save();
        }
    }

    public function hasUwnetid()
    {
        return is_string($this->uwnetid) && preg_match('/^[A-Za-z0-9]{1,8}$/', $this->uwnetid);
    }

    public function canAuthorize()
    {
        return (boolean) DB::table('shared.coe_authorized')
            ->where('uwnetid', $this->uwnetid)
            ->count();
    }

    public function needsAuthorization()
    {
        $user = new User($this->uwnetid);
        return ! hasRole(self::MIN_AUTH_ROLE, $user);
    }

}
