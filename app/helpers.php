<?php

use App\Models\Profile;

if (!function_exists('get_profile_route')) {
    function get_profile_route(?Profile $profile): string
    {
        if (!$profile) return route('landing');

        $isRestaurant = $profile->user_type === 'Restaurant';

        return match (true) {
            $isRestaurant && auth('user')->check()=> route('restaurant.perfil.user', $profile),
            !$isRestaurant && auth('user')->check()=> route('perfil.user.ajeno', $profile),
            $isRestaurant && auth('restaurant')->check()=> route('perfil.ajeno.restaurante', $profile),
            !$isRestaurant && auth('restaurant')->check()=> route('user.perfil.restaurante', $profile),
            default=> route('landing'),
        };
    }
}