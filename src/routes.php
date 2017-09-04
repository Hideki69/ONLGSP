<?php

use App\Provider\IndexControllerProvider;

$app->mount('/', new IndexControllerProvider());