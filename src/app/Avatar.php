<?php
namespace App;

class Avatar
{
    protected $avatars;
    public function __construct($avatars)
    {
        $this->avatars = $avatars;
    }
    public function get($mode)
    {
        if(!$this->avatars) return null;
        return $this->avatars->get($mode) ?: $this->avatars->get('medium') ?: $this->avatars->get('original');
    }

    public function url($mode)
    {
        if($get = $this->get($mode)){
            return $get->url;
        }
        return '/images/avatar/user.png';
    }
}
