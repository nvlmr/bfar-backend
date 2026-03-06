<?php
// app/core/Controller.php

class Controller
{
    protected $db; // Add database property

    public function __construct()
    {
        // Initialize database connection for all controllers
        $this->initDB();
    }

    private function initDB()
    {
        // Only initialize if Database class exists
        if (class_exists('Database')) {
            $database = new Database();
            $this->db = $database->connect();
        }
    }

    protected function view($view, $data = [])
    {
        extract($data);

        $file = __DIR__ . "/../views/{$view}.php";

        if (file_exists($file)) {
            require_once $file;
        } else {
            die("View not found: " . $file);
        }
    }

    protected function model($model)
    {
        $file = __DIR__ . "/../models/{$model}.php";

        if (file_exists($file)) {
            require_once $file;
            
            // If model expects database connection, pass it
            if ($this->db) {
                return new $model($this->db);
            }
            
            // Otherwise create without parameters
            return new $model();
        }

        die("Model not found: " . $file);
    }

    // Helper method to get database connection
    protected function getDB()
    {
        return $this->db;
    }
}