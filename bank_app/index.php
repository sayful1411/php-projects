#! /usr/bin/env php
<?php

use App\Main\BankCLIApp;

require_once __DIR__ . "/vendor/autoload.php";

$BankCLIApp = new BankCLIApp();
$BankCLIApp->run();