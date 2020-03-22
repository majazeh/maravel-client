<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('dashboard.home', function ($trail, $data) {
    $trail->push(__('Home'), route('dashboard.home'));
});

# Users
Breadcrumbs::for('dashboard.users.index', function ($trail, $data) {
    $trail->parent('dashboard.home', $data);
    $trail->push(__('Users'), route('home'));
});
Breadcrumbs::for('dashboard.users.show', function ($trail, $data) {
    $trail->parent('dashboard.users.index', $data);
    $trail->push($data['user']->name ?: __('Anonymouse'), route('dashboard.users.show', $data['user']->id));
});

Breadcrumbs::for('dashboard.users.edit', function ($trail, $data) {
    $trail->parent('dashboard.users.show', $data);
    $trail->push(__('Edit'), route('home'));
});

Breadcrumbs::for('dashboard.users.create', function ($trail, $data) {
    $trail->parent('dashboard.users.index', $data);
    $trail->push(__('Create new user'), route('home'));
});

# Terms
Breadcrumbs::for('dashboard.terms.index', function ($trail, $data) {
    $trail->parent('dashboard.home', $data);
    $trail->push(__('Terms'), route('home'));
});
Breadcrumbs::for('dashboard.terms.show', function ($trail, $data) {
    $trail->parent('dashboard.terms.index', $data);
    $trail->push($data['term']->title, route('dashboard.terms.show', $data['term']->id));
});

Breadcrumbs::for('dashboard.terms.edit', function ($trail, $data) {
    $trail->parent('dashboard.terms.show', $data);
    $trail->push(__('Edit'), route('home'));
});

Breadcrumbs::for('dashboard.terms.create', function ($trail, $data) {
    $trail->parent('dashboard.terms.index', $data);
    $trail->push(__('Create new term'), route('home'));
});
