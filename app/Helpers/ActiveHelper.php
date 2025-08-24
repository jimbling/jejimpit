<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('isActiveRoute')) {
    /**
     * Return active class if current route match one of the given routes
     */
    function isActiveRoute(array|string $routes, string $output = 'active'): string
    {
        foreach ((array) $routes as $route) {
            if (Route::is($route)) { // support wildcard *.index
                return $output;
            }
        }
        return '';
    }
}

if (!function_exists('isActiveParent')) {
    /**
     * Return active+show class for parent menu if one of child routes match
     */
    function isActiveParent(array|string $routes, string $output = 'active show'): string
    {
        foreach ((array) $routes as $route) {
            if (Route::is($route)) {
                return $output;
            }
        }
        return '';
    }
}

if (!function_exists('isDropdownOpen')) {
    /**
     * Return "show" if child menu is active (for Bootstrap dropdowns)
     */
    function isDropdownOpen(array|string $routes, string $output = 'show'): string
    {
        foreach ((array) $routes as $route) {
            if (Route::is($route)) {
                return $output;
            }
        }
        return '';
    }
}
