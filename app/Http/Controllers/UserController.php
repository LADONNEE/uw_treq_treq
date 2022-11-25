<?php

namespace App\Http\Controllers;

use App\Auth\User;
use App\AuthNotify\UserModified;
use App\Models\AuthLog;
use App\Models\UserFolder;
use App\Models\Person;
use App\Reports\UserOrdersReport;
use App\Reports\UsersReport;
use App\Trackers\LoggedAuth;
use Carbon\Carbon;

class UserController extends Controller
{
    public function add()
    {
        $personId = request('person_id');

        if ($personId) {

            $person = Person::where('person_id', $personId)->first();

            if ($person instanceof Person && $person->uwnetid) {

                return redirect()->action('UserController@edit', $person->uwnetid);
            }
        }
        abort(404);
    }

    public function index()
    {
        $users = (new UsersReport())->getReport();
        $logs = AuthLog::orderBy('created_at', 'desc')
            ->where('created_at', '>', Carbon::now()->subDays(30))
            ->with('actor')
            ->get();
        return view('user/index', compact('users', 'logs'));
    }

    public function show($uwnetid)
    {
        $user = user($uwnetid);
        if (!$user->person_id) {
            abort(404);
        }

        $orders = (new UserOrdersReport())->getReport($user->person_id);

        return view('user.show', compact('user', 'orders'));
    }

    public function edit($uwnetid)
    {
        $this->authorize('user-mgmt');
        $user = user($uwnetid);
        $noAuth = count($user->getRoles()) === 0;
        $userFolder = UserFolder::firstOrNew(['person_id' => $user->person_id]);
        return view('user/edit', compact('user', 'userFolder', 'noAuth'));
    }

    public function update($uwnetid)
    {
        $this->authorize('user-mgmt');
        $user = user($uwnetid);

        $role = request('role');
        $roles = ($role) ? [$role] : [];

        $cmd = new LoggedAuth($user, user()->person_id);
        $cmd->save($roles);

        $this->updateUserFolder($user, request('file_folder'));

        event(new UserModified($uwnetid, user()->uwnetid));

        return redirect()->action('UserController@index');
    }

    private function updateUserFolder(User $user, $url)
    {
        if ($url) {
            $uf = UserFolder::firstOrNew(['person_id' => $user->person_id]);
            if ($url !== $uf->url) {
                $uf->url = $url;
                $uf->created_by = user()->person_id;
                $uf->save();
            }
        } else {
            UserFolder::where('person_id', $user->person_id)->delete();
        }
    }
}
