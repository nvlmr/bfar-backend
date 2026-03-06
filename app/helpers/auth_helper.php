<?php

function user()
{
    return $_SESSION['user'] ?? null;
}

function user_id()
{
    return $_SESSION['user_id'] ?? null;
}

function user_role()
{
    return $_SESSION['role'] ?? null;
}

function is_logged_in()
{
    return isset($_SESSION['user_id']);
}