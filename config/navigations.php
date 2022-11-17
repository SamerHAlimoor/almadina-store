<?php

return [

    [
        'icon' => 'fas fa-tags nav-icon',
        'route' => 'dashboard.categories.index',
        'title' => 'Categories',
        'badge' => 'New',
        'active' => 'dashboard.categories.*',
        'ability' => 'categories.view',
        'create_route' => 'dashboard.categories.create',
        'trash' => 'dashboard.categories.trash'

    ],
    [
        'icon' => 'fas fa-box nav-icon',
        'route' => 'dashboard.products.index',
        'title' => 'Products',
        'active' => 'dashboard.products.*',
        'ability' => 'products.view',
        'create_route' => 'dashboard.products.create',
        'trash' => 'dashboard.categories.trash'

    ],
    [
        'icon' => 'fas fa-receipt nav-icon',
        'route' => 'dashboard.categories.index',
        'title' => 'Orders',
        'active' => 'dashboard.orders.*',
        'ability' => 'orders.view',
        'create_route' => 'dashboard.dashboard',
        'trash' => 'dashboard.categories.trash'
    ],
    [
        'icon' => 'nav-icon fas fa-code',
        'route' => 'dashboard.roles.index',
        'title' => 'Roles',
        'active' => 'dashboard.roles.*',
        'ability' => 'roles.view',
        'create_route' => 'dashboard.roles.create',
        'trash' => 'dashboard.categories.trash'
    ],
    [
        'icon' => 'fas fa-users nav-icon',
        'route' => 'dashboard.categories.index',
        'title' => 'Users',
        'active' => 'dashboard.users.*',
        'ability' => 'users.view',
        'create_route' => 'dashboard.categories.index',
        'trash' => 'dashboard.categories.trash'
    ],
    [
        'icon' => 'fas fa-users nav-icon',
        'route' => 'dashboard.categories.index',
        'title' => 'Admins',
        'active' => 'dashboard.admins.*',
        'ability' => 'admins.view',
        'create_route' => 'dashboard.categories.index',
        'trash' => 'dashboard.categories.trash'
    ],


];