<?php

if (!function_exists('externalAuth')) {
    function externalAuth()
    {
        return session('user') && session('external_auth');
    }
}

if (!function_exists('currentUser')) {
    function currentUser()
    {
        return session('user');
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        $user = currentUser();
        return $user && $user['role_id'] === 2;
    }
}
if (!function_exists('isAgent')) {
    function isAgent()
    {
        $user = currentUser();
        return $user && $user['role_id'] === 4;
    }
}
