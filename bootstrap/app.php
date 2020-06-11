<?php
/**
 * 這是一個導引檔案
 */

// 很抱歉，由於我們沒有實做自動加載器，所以得手動 require 檔案。
require __DIR__ . '/lib/Database/Accessor.php';
require __DIR__ . '/lib/Database/DB.php';

require __DIR__ . '/lib/ResponseEmitter/ResponseEmitter.php';
require __DIR__ . '/lib/Middleware/SessionMiddleware.php';
require __DIR__ . '/view.php';
require __DIR__ . '/services.php';

$config = require __DIR__ . '/config/database.php';

DB::connect($config);

$routes = require __DIR__ . '/routes.php';
$middleware = require __DIR__ . '/middleware.php';
