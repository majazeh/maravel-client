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
    public function authForm(Request $request, $method = 'home')
    {
        $this->data->theoryRouteParms = [];
        if($request->session()->previousUrl() != url()->current() || $request->previousUrl)
        {
            $this->data->theoryRouteParms['previousUrl'] = $request->previousUrl ?: $request->session()->previousUrl();
        }
        if ($request->callback) {
            $this->data->theoryRouteParms['callback'] = $request->callback;

        }
        return $this->view($request, "auth.$method");
    }

    public function registerForm(Request $request){
        $this->data->global->title = __('Register');
        if(auth()->check()){
            return redirect()->route('dashboard.home');
        }
        return $this->authForm($request, 'register');
    }

    public function recoveryForm(Request $request)
    {
        $this->data->global->title = __('Recovery');
        if (auth()->check()) {
            return redirect()->route('dashboard.home');
        }
        return $this->authForm($request, 'recovery');
    }

    public function auth(Request $request)
    {
        return $this->authParse(User::auth($request->all()), $request);
    }
    public function register(Request $request)
    {
        return $this->authParse(User::register($request->all()), $request);
    }
    public function recovery(Request $request)
    {
        return $this->authParse(User::recovery($request->all()), $request);
    }

    public function authTheoryForm(Request $request, $key)
    {
        $this->data->global->title = __('Auth theory '. $request->form);
        $form = $request->form != 'auth' || $request->user() ? '.' . $request->form : '';
        if ($form == '.auth') {
            try {
                $auth = User::authTheory($key);
                $this->data->message = $auth->response('message_text');
            } catch (APIException $e) {
                $this->data->message = $auth->response('message_text');
            }
        }
        $this->data->theoryRouteParms = [
            'key' => $key
        ];
        if($request->callback)
        {
            $this->data->theoryRouteParms['callback'] = $request->callback;
        }
        if ($request->previousUrl) {
            $this->data->theoryRouteParms['previousUrl'] = $request->previousUrl;
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
        if($request->previousUrl){
            $theory['previousUrl'] = $request->previousUrl;

        }
        $response = [];
        $response = [
            'redirect' => $auth->response('theory') || $auth->response('callback')
                ? ($auth->response('theory') == 'auth' && !$auth->response('key') ? route('auth', ['callback' => $auth->response('callback')]) : route('auth.theory', $theory))
                : ($request->previousUrl ?: route('dashboard.home')),
            'direct' => $auth->response('theory') || $auth->response('callback') ? false : true
        ];
        $response['is_ok'] = true;
        if ($auth->response('token')) {
            $response['message'] = __('Welcome :*');
            $response['message_text'] = __('Welcome :*');
            $request->session()->put('APIToken', $auth->response('token'));
            $request->session()->put('User', $auth->response()->toArray());
            $request->session()->put('User_cacheed_at', time());

        }
        $theoryMethod = 'authTheory' . ucfirst(\Str::camel($auth->response('theory')));
        if(method_exists($this, $theoryMethod) && $auth->response('theory'))
        {
            $response = $this->$theoryMethod($request, $auth, $response);
        }
        return $response;
    }
    public function authTheoryAuth($request, $auth, $response){
        if($auth->response('key')){
            return $this->authTheory(request(), $auth->response('key'));
        }
        return $response;
    }
    public function logout(Request $request)
    {
        $logout = (new User)->execute('logout', [], 'post');
        $request->session()->forget('APIToken');
        $request->session()->forget('User');
        return response()->json(array_merge($logout->response()->toArray(), [
            'redirect' => route('auth'),
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
        $request->request->add([
            'previousUrl' => $request->headers->get('referer')
        ]);
        return $this->authParse(User::authBack(), $request);
    }
}
