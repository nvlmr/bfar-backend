<?php

class Middleware
{
    public static function auth()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    public static function guest()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL);
            exit;
        }
    }

    public static function role($requiredRole)
    {
        if (!isset($_SESSION['role'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        if ($_SESSION['role'] !== $requiredRole) {
            echo "Access Denied";
            exit;
        }
    }
}