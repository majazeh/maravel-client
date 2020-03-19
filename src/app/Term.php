<?php
namespace App;

class Term extends API
{
    protected $guarded = [];
    public $with = [
        'creator' => User::class,
        'parents' => Term::class
    ];

    public $filterWith = [
        'creator' => User::class,
        'parent' => Term::class
    ];
}
