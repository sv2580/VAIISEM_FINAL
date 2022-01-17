<?php
require "ClassLoader.php";

use App\App;
session_start();

$app = new App();
$app->run();