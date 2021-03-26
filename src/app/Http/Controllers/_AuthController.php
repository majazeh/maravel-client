<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Exceptions\APIException;
use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
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
        if(isset($this->data->theoryRouteParms['previousUrl']) && $this->data->theoryRouteParms['previousUrl'] == route('auth')){
            $this->data->theoryRouteParms['previousUrl'] = null;
        }
        if ($request->callback) {
            $this->data->theoryRouteParms['callback'] = $request->callback;

        }
        $this->data->route = 'auth';
        return $this->view($request, "auth.$method");
    }

    public function registerForm(Request $request){
        $this->data->global->title = __('Register');
        if(auth()->check()){
            return redirect()->route('dashboard.home');
        }
        $this->data->route = 'register';
        $this->urlRd($request, 'register');
        return $this->view($request, 'auth.register');
    }

    public function recoveryForm(Request $request)
    {
        $this->data->global->title = __('Recovery');
        if (auth()->check()) {
            return redirect()->route('dashboard.home');
        }
        $this->urlRd($request, 'recovery');
        $this->data->route = 'auth.recovery';
        return $this->view($request, 'auth.recovery');
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

    public function authTheoryForm(Request $request, $key, $model = null)
    {
        try {
            $model = $model ?: User::authResult($key);
        } catch (APIException $e) {
            return redirect()->route('auth');
        }
        $this->data->route = 'auth.theory';
        $theory = $model->response('theory');
        $this->data->theory = $model;
        $this->data->global->title = __('Auth theory '. $theory);
        $form = $theory != 'auth' || $request->user() ? '.' . $theory : '';
        $this->data->global->page = 'auth-theory-' . $theory;
        $this->urlRd($request, $key);
        return $this->view($request, 'auth.theory' . $form);
    }

    public function urlRd($request, $key){
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
        if(!$response['direct'] && isset($theory['key'])){
            $this->data->global->state = $response['redirect'];
            return $this->authTheoryForm($request, $theory['key'], $auth, $response);
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
