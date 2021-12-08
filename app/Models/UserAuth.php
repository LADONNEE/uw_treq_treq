<?php
namespace App\Models;

class UserAuth
{
    public function save($uwnetid, array $roles)
    {
        if (count($roles) === 0) {
            Auth::where('uwnetid', $uwnetid)
                ->where('role', '<>', 'treq:super')
                ->delete();
        } else {
            Auth::where('uwnetid', $uwnetid)
                ->whereNotIn('role', $roles)
                ->where('role', '<>', 'treq:super')
                ->delete();
        }
        $has = $this->has($uwnetid);
        foreach ($roles as $role) {
            if (!in_array($role, $has)) {
                Auth::firstOrCreate([
                    'uwnetid' => $uwnetid,
                    'role' => $role
                ]);
            }
        }
    }

    private function has($uwnetid)
    {
        return Auth::where('uwnetid', $uwnetid)
            ->pluck('role')
            ->all();
    }
}
