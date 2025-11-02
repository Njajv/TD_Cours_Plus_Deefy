<?php

namespace IUT\Spotify;

class CookieProvider {
    public function getCookie(string $name): ?string {
        return $_COOKIE[$name] ?? null;
    }

    public function createCookie(string $name, string $value, int $expire = 3600): void {
        setcookie($name, $value, time() + $expire);
    }
}