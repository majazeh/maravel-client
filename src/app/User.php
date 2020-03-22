<?php
namespace App;

use App\Models\ApiResponse;

class User extends API
{
    protected $guarded = [];
    public $with = [
        'avatar' => File::class
    ];
    public static $me = null;
    public static $token;

    public static function token()
    {
        static::$token = session()->get('APIToken');
        if(static::$token)
        {
            $userResponse = session()->get('User');
            $response = new ApiResponse(0, $userResponse);
            $userModel = new static((array) $userResponse['data'], $response);
            static::$me = $userModel;
        }
        return static::$token;
    }

    public static function me()
    {
        if(static::$me)
        {
            return static::$me;
        }
        return (new static)->cache('me');
    }

    public static function auth($params = [])
    {
        return (new static)->execute('auth', $params, 'post');
    }
    public static function register(array $params = [])
    {
        return (new static)->execute('register', $params, 'post');
    }
    public static function verification(array $params = [])
    {
        return (new static)->execute('auth/verification', $params, 'post');
    }
    public static function authAs($user, $params = [])
    {
        return (new static)->execute('auth/as/'. $user, $params, 'post');
    }
    public static function authBack($params = [])
    {
        return (new static)->execute('auth/back', $params, 'post');
    }

    public static function authTheory($key, array $parameters = [])
    {
        return (new static)->execute("auth/theory/$key", $parameters, 'post');
    }
    public static function recovery(array $parameters = [])
    {
        return (new static)->execute("auth/recovery", $parameters, 'post');
    }
    public function isAdmin()
    {
        return $this->type == 'admin';
    }
    public function getAvatarUrlAttribute()
    {
        return new Avatar($this->avatar);
    }
}
