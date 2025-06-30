<?php

echo 'Loading SoundVitrine...';

// display errors on http response
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

//
//
//

//
define("SOURCE_PHP_ROOT", __DIR__ . '/_src');
define("PUBLIC_FILES_ROOT", __DIR__ . '/public');
define("STATE_FILES_ROOT", __DIR__ . '/_state');
define("SERVICES_SCRIPT_ROOT", SOURCE_PHP_ROOT . '/services');

//
set_include_path(SOURCE_PHP_ROOT);

//
Swoole\Runtime::enableCoroutine(SWOOLE_HOOK_ALL); // Enable all coroutine hooks before starting any server

//
include SERVICES_SCRIPT_ROOT . '/_config.php'; 
include SERVICES_SCRIPT_ROOT . '/www.php'; 
include SERVICES_SCRIPT_ROOT . '/websocket.php';

//
//
//

use Swoole\HTTP\Server;
$server = new Server("0.0.0.0", SERVICE_WWW_PORT);
$server->set([
    'enable_coroutine' => true,
    // 'daemonize' => false,
    'worker_num' => 1
]);

//
$server->on('WorkerStart', function(Server $serv, $workerId) {
    // Include files from here so they can be reloaded...
    include SOURCE_PHP_ROOT . '/index.php'; // Include your standard PHP script
});

$server->on('WorkerExit', function(Server $server, int $workerId) {
    //Prevent worker exit timeout issues (similar to die/exit)
    //@see: https://openswoole.com/docs/modules/swoole-event-exit
    \Swoole\Timer::clearAll();
    \Swoole\Event::Exit();
});

//
// WWW
//

$server->on("request", "wwwService");

//
//
//

$server->start();
Swoole\Event::wait();
