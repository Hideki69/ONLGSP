<?php

use App\Provider\AdminControllerProvider;

$app->mount('/', new AdminControllerProvider());