<?php

require_once  'autoload.php';

$dsn = 'mysql:host=localhost;port=3306;dbname=portofolio;charset=utf8mb4';

$database = new Database($dsn);

$pdo = $database->getCon();




