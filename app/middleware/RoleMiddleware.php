<?php

class RoleMiddleware
{
    public static function handle($role)
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
            http_response_code(403);
            exit('Unauthorized access.');
        }
    }
}