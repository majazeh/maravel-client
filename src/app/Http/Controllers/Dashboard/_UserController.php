<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\User;

class _UserController extends Controller
{
    public function index(Request $request)
    {
        $this->data->users = User::apiIndex($request->all(['order', 'sort', 'status', 'type', 'gender', 'page']));
        return $this->view($request, 'dashboard.users.index');
    }

    public function create(Request $request)
    {
        return $this->view($request, 'dashboard.users.create');
    }

    public function store(Request $request)
    {
        return User::apiStore($request->except('_method'))->response()->json([
            'redirect' => route('dashboard.users.create')
        ]);
    }

    public function avatarStore(Request $request, $user)
    {
        $avatar = new User;
        return $avatar->execute("%s/$user/avatar", $request->all('avatar'), 'POST')->response()->json();
    }

    public function edit(Request $request, User $user)
    {
        $this->data->user = $user;
        return $this->view($request, 'dashboard.users.create');
    }
    public function update(Request $request, $user)
    {
        return User::apiUpdate($user, $request->except('_method'))->response()->json([
            'redirect' => route('dashboard.users.edit', [
                'user' => $user,
                'userview' => $request->userview
                ])
            ]);
    }

    public function show(Request $request, User $user)
    {
        $this->data->user = $user;
        return $this->view($request, 'dashboard.users.show');
    }

    public function me(Request $request)
    {
        $this->data->user = User::me();
        return $this->view($request, 'dashboard.users.show');
    }
    public function editMe(Request $request)
    {
        $this->data->user = User::me();
        $this->data->module->result = 'user';
        return $this->view($request, 'dashboard.users.create');
    }

}
