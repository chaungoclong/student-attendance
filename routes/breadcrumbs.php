<?php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Admin
Breadcrumbs::for('admin.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Admin', route('admin.dashboard'));
});

// Admin > List Admin
Breadcrumbs::for('admin.admin-manager.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('List Admin', route('admin.admin-manager.index'));
});

// Admin > Create
Breadcrumbs::for('admin.admin-manager.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Create', route('admin.admin-manager.create'));
});

// Admin > List Admin > [Admin]
Breadcrumbs::for('admin.admin-manager.show', function (BreadcrumbTrail $trail, $admin) {
    $trail->parent('admin.admin-manager.index');
    $trail->push($admin->name, route('admin.admin-manager.show', $admin));
});