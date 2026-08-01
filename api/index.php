<?php

// 1. Paksa PHP tampilkan error mentah sebelum Laravel boot
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// 2. Forward request ke public/index.php Laravel
require __DIR__ . '/../public/index.php';