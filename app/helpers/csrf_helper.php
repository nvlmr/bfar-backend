<?php

function csrf_token()
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_field()
{
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

function verify_csrf()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!isset($_POST['csrf_token'])) {
            http_response_code(403);
            exit('CSRF token missing');
        }

        if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            http_response_code(403);
            exit('Invalid CSRF token');
        }
    }
}