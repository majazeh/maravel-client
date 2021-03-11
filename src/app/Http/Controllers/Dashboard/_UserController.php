<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\User;

class _UserController extends Controller
{
    public function index(Request $request)
    {
        $this->data->users = User::apiIndex($request->all());
        return $this->view($request, 'dashboard.users.index');
    }

    public function create(Request $request)
    {
        return $this->view($request, 'dashboard.users.create');
    }

    public function store(Request $request)
    {
        $user = User::apiStore($request->except('_method'));
        return $user->response()->json([
            'redirect' => route('dashboard.users.show', $user->id)
        ]);
    }

    public function avatarStore(Request $request, $user)
    {
        $avatar = new User;
        $reesponse = $avatar->execute("%s/$user/avatar", $request->all('avatar'), 'POST');
        $request->session()->put('User', (new User)->execute("me")->response()->toArray());
        return $reesponse->response()->json();
    }

    public function edit(Request $request, User $user)
    {
        $this->data->user = $user;
        return $this->view($request, 'dashboard.users.create');
    }
    public function update(Request $request, $user)
    {
        $reesponse = User::apiUpdate($user, $request->except('_method'));
        if(auth()->id() == $reesponse->id){
            $request->session()->put('User', (new User)->execute("me")->response()->toArray());
        }
        return response()->json([
            'redirect' => route('dashboard.users.edit', [
                'user' => $user,
                'userview' => $request->userview
                ])
            ]);
    }

    public function changePassword(Request $request, User $user){
        return (new User)->execute('%s/' . $user->id . '/change-password', $request->all(), 'PUT')->response()->json();
    }

    public function show(Request $request, User $user)
    {
        $this->data->user = $user;
        return $this->view($request, 'dashboard.users.show');
    }

    public function me(Request $request)
    {
        User::$me = null;
        return $this->show($request, User::me());
    }
    public function editMe(Request $request)
    {
        $this->data->user = User::me();
        $this->data->module->result = 'user';
        return $this->view($request, 'dashboard.users.create');
    }

}
