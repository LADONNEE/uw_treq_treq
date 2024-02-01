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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client as GuzzleClient;

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

    public function userHasRole($personid, $role)
    {
        $data = 'no permission';
        if ($personid) {
            $person = Person::where('person_id', $personid)->first();
            if ($person instanceof Person && $person->uwnetid) {
                if(hasRole($role, user($person->uwnetid))) {
                    $data = 'permitted';
                }
            }
        }
        return $data;
        
        
    }

    public function userCanApprove($personid)
    {
        $data = 'no permission';
        if ($personid) {
            $person = Person::where('person_id', $personid)->first();

            if ($person instanceof Person && $person->uwnetid) {
                if(  $personid != user()->person_id ||  ( $personid == user()->person_id && hasRole('treq:fiscal', user($person->uwnetid) )  )   ) {
                    $data = 'permitted';
                }
            }
        }
        return $data;
        
        
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

    // Call searchpersons to import User in uw_persons database
    public function import()
    {
        //$user_data = request('uwperson_data');
        //$personId = $user_data->uwperson_id;
        $personId = request('uwperson_id');
        
        Log::debug('Treq Import');

        if ($personId) {
            
            Log::debug('got personid');
            Log::debug($personId);

            
            $apiPersonImportUrl = config('app.url') . '/searchpersons/import-uw';
            
            $verifySsl = true;
            //For development only, disable ssl-verify
            if(config('app.env') != 'production' ) {
                $verifySsl = false;
            }

            $response = Http::withOptions(["verify"=>$verifySsl])
                        ->get( $apiPersonImportUrl, [
                            'a' => $personId,
                        ]);
            
            // $response = Http::get( $postUrl, [
            //     'person_id' => $personId,
            // ]);

            Log::debug('RESPONSE');
            Log::debug($response);
            Log::debug($response->status());

            // Log::debug($response);

            if ($response->status() == 200) { 
                
                $person = Person::where('person_id', $personId)->first();
                if ($person instanceof Person && $person->uwnetid) {
                    return redirect()->action('UserController@edit', $person->uwnetid);
                }
            
            }


        }

        Log::debug("we there");

        // abort(404);
    }



}
