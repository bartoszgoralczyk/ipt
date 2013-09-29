<?php

include ("core/ini.php");
initializer::initialize();
$router = loader::load("router");
dispatcher::dispatch($router);

