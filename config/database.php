<?php

declare(strict_types=1);

function getConnection(): PDO
{
    $host = 'mysql';
    $dbname = 'therapy_dashboard_php';
    $username = 'root';
    $password = 'root';

    $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";

    return new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
}
