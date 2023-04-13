<?php
// $constants = [
//     'HTTP_CODE'  => [
//         'GET' => '200',
//         'CREATED' => '201',
//         'BAD_REQUEST' => 400,
//         'INTERNAL_SERVER_ERROR' => 500,
//     ]
// ];
if (!defined('GET')) {
    define('GET', 200);
}
if (!defined('CREATED')) {
    define('CREATED', 201);
}
if (!defined('BAD_REQUEST')) {
    define('BAD_REQUEST', 400);
}
if (!defined('INTERNAL_SERVER_ERROR')) {
    define('INTERNAL_SERVER_ERROR', 500);
}
