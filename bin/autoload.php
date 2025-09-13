<?php

declare(strict_types=1);
require BASE_PATH .  '/vendor/autoload.php';
//spl_autoload_register(array('\Bin\App\App', 'findClass'), true, false);
spl_autoload_register(['\Bin\App\App', 'make'], true, false);
spl_autoload_register(['\Bin\App\App', 'facade'], true, false);

require basePath() . '/app/routes.php';