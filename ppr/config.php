<?php
// Edit these for your server (XAMPP defaults shown)
const DB_HOST='localhost', DB_NAME='pawpathrole', DB_USER='root', DB_PASS='';
session_start();
ob_start(); // lets pages redirect after HTML has started
function db(): PDO {
    static $pdo;
    return $pdo ??= new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4', DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);
}
function e(?string $s): string { return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); }
function csrf(): string { return $_SESSION['csrf'] ??= bin2hex(random_bytes(16)); }
function check_csrf(): void { if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(400); exit('Invalid request'); } }
