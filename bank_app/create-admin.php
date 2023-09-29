#! /usr/bin/env php
<?php 

namespace App;

use App\Admin\Admin;
use App\Main\CustomerStorage;

require_once __DIR__ . "/vendor/autoload.php";


$admin = new Admin(new CustomerStorage);
$admin->run();