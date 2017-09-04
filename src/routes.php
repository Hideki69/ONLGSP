<?php

use App\Provider\IndexControllerProvider;
use App\Provider\UserControllerProvider;

$app->mount('/', new IndexControllerProvider());
$app->mount('/user', new UserControllerProvider());