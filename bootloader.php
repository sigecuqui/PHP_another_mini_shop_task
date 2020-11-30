<?php

session_start();

define('ROOT', __DIR__);
define('DB_FILE', ROOT . '/app/data/db.json');

// App
require 'app/functions/form/validators.php';
require 'app/functions/auth.php';
require 'app/functions/generators.php';

// Core
require 'core/functions/form/core.php';
require 'core/functions/form/validators.php';
require 'core/functions/file.php';
require 'core/functions/html.php';
