<?php
// Router script for PHP built-in server
// Handles requests for files outside the public/ document root

$uri = $_SERVER["REQUEST_URI"];
$path = parse_url($uri, PHP_URL_PATH);

// Root path: let the built-in server serve index.php from public/
if ($path === "/") {
    return false;
}

// If the file exists under public/, let the built-in server handle it
$publicFile = __DIR__ . "/public" . $path;
if (file_exists($publicFile) && is_file($publicFile)) {
    return false;
}

// Check if file exists elsewhere in the app directory
$appFile = __DIR__ . $path;
if (file_exists($appFile) && is_file($appFile)) {
    $ext = pathinfo($appFile, PATHINFO_EXTENSION);

    if ($ext === "php") {
        // chdir so that relative require/include paths resolve correctly
        $cwd = getcwd();
        chdir(dirname($appFile));
        require $appFile;
        chdir($cwd);
        return true;
    }

    // Serve static files (CSS, JS, images, etc.)
    $mimeTypes = [
        "css" => "text/css",
        "js" => "application/javascript",
        "svg" => "image/svg+xml",
        "png" => "image/png",
        "jpg" => "image/jpeg",
        "jpeg" => "image/jpeg",
        "gif" => "image/gif",
        "ico" => "image/x-icon",
    ];

    if (isset($mimeTypes[$ext])) {
        header("Content-Type: " . $mimeTypes[$ext]);
        readfile($appFile);
        return true;
    }

    return false;
}

// 404 — nothing matched
http_response_code(404);
echo "404 Not Found";
