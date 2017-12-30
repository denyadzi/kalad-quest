<?php

$params = require (__DIR__ . '/params_local.php');

return array_merge ([
    'adminEmail' => 'admin@example.com',
    'user.passwordResetTokenExpire' => 3600, 
], $params);
