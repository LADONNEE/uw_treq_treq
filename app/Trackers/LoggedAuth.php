<?php
namespace App\Trackers;

use App\Auth\User;
use App\Models\AuthLog;
use App\Models\UserAuth;

class LoggedAuth
{
    /**
     * @var User
     */
    private $user;
    private $actor_id;

    public function __construct(User $user, $actor_id)
    {
        $this->user = $user;
        $this->actor_id = $actor_id;
    }

    public function save(array $newRoles)
    {
        $oldRoles = $this->user->getRoles();
        asort($oldRoles);
        asort($newRoles);

        if ($newRoles == $oldRoles) {
            return;
        }

        $auth = new UserAuth();
        $auth->save($this->user->uwnetid, $newRoles);

        $log = $this->newLog();
        if ($newRoles) {
            $log->message = 'set role to ' . implode(', ', $newRoles);
        } else {
            $log->message = 'removed all roles';
        }
        $log->save();
    }

    public function newLog()
    {
        return new AuthLog([
            'uwnetid' => $this->user->uwnetid,
            'actor_id' => $this->actor_id,
        ]);
    }
}
