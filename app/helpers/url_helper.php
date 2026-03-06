<?php

function upload_file($file, $directory = 'uploads/')
{
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $filename = time() . '_' . basename($file['name']);
    $targetPath = ROOT_PATH . '/public/' . $directory . $filename;

    if (!is_dir(ROOT_PATH . '/public/' . $directory)) {
        mkdir(ROOT_PATH . '/public/' . $directory, 0755, true);
    }

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $directory . $filename;
    }

    return false;
}