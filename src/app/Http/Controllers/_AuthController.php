<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Exceptions\APIException;
use Symfony\Component\HttpFoundation\Cookie;

class _AuthController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->data->layouts->vendor->arraySetTrue([
            'select2',
            'persian_datepicker',
            'amcharts4',
            'fontawesome',
            'iziToast',
            'dashboardTheme',
            'popper'
        ]);
    }
    public function authForm(Request $request)
    {
        $this->data->theoryRouteParms = [];
        if ($request->callback) {
            $this->data->theoryRouteParms['callback'] = $request->callback;
        }
        return $this->view($request, 'auth.home');
    }
    public function auth(Request $request)
    {
        return $this->authParse(User::auth($request->all()), $request);
    }

    public function authTheoryForm(Request $request, $key)
    {
        $form = $request->form != 'auth' || $request->user() ? '.' . $request->form : '';
        if ($form == '.auth') {
            try {
                $auth = User::authTheory($key);
                $this->data['message'] = $auth->message_text;
            } catch (APIException $e) {
                $this->data['message'] = $e->message_text;
            }
        }
        $this->data->theoryRouteParms = [
            'key' => $key
        ];
        if($request->callback)
        {
            $this->data->theoryRouteParms['callback'] = $request->callback;
        }
        return $this->view($request, 'auth.theory' . $form);
    }

    public function authTheory(Request $request, $key)
    {
        try {
            return $this->authParse(User::authTheory($key, $request->all()), $request);
        } catch (APIException $e) {
            if ($e->statusCode() == 403) {
                return response()->json([
                    'is_ok' => true,
                    'message' => $e->message,
                    'message_text' => $e->message_text,
                    'redirect' => route('auth')
                ]);
            } elseif ($e->statusCode() == 404) {
                return response()->json([
                    'is_ok' => false,
                    'message' => 'THEORY_NOT_FOUND',
                    'message_text' => __('THEORY_NOT_FOUND'),
                    'redirect' => route('auth')
                ]);
            } else {
                return $e->json();
            }
        }
    }

    public function authParse($auth, $request)
    {
        $theory = [];
        $key = null;
        if ($auth->response('theory')) {
            $theory['form'] = $auth->response('theory');
        }
        if ($auth->response('callback')) {
            $theory['callback'] = $auth->response('callback');
        }
        if ($auth->response('key')) {
            $theory['key'] = $auth->response('key');
        }
        $response = [];
        $response = [
            'redirect' => $auth->response('theory') || $auth->response('callback')
                ? $auth->response('theory') == 'auth' && !$auth->response('key') ? route('auth', ['callback' => $auth->response('callback')]) : route('auth.theory', $theory)
                : route('dashboard.home'),
            'direct' => $auth->response('theory') || $auth->response('callback') ? false : true
        ];
        if ($auth->response('token')) {
            $response['message'] = __('Welcome :*');
            $response['message_text'] = __('Welcome :*');
            $request->session()->put('APIToken', $auth->response('token'));
            $request->session()->put('User', $auth->response()->toArray());

        }
        return $response;
    }
    public function logout(Request $request)
    {
        $request->session()->forget('APIToken');
        $request->session()->forget('User');
        $logout = (new User)->execute('logout', [], 'post');
        return response()->json(array_merge_recursive($logout->response()->toArray(), [
            'redirect' => '/dashboard',
            'direct' => true
        ]))
        ->withCookie(new Cookie('token', null));
    }
    public function authAs(Request $request, $user)
    {
        $authAs = User::authAs($user);
        return $this->authParse($authAs, $request);
    }
    public function authBack(Request $request)
    {
        return $this->authParse(User::authBack(), $request);
    }
}
