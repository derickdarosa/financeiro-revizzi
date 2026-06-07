<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/app/Core/Router.php';
require_once __DIR__ . '/app/Controllers/Controller.php';
require_once __DIR__ . '/app/Models/Lancamento.php';
require_once __DIR__ . '/app/Controllers/AuthController.php';
require_once __DIR__ . '/app/Controllers/LancamentoController.php';
require_once __DIR__ . '/app/Controllers/RelatorioController.php';

$router = new Router();

// Auth
$router->get('/login',   [AuthController::class, 'showLogin']);
$router->post('/login',  [AuthController::class, 'login']);
$router->get('/logout',  [AuthController::class, 'logout']);

// Páginas
$router->get('/',           [RelatorioController::class,  'index']);
$router->get('/entradas',   [LancamentoController::class, 'entradas']);
$router->get('/saidas-var', [LancamentoController::class, 'saidasVariaveis']);
$router->get('/saidas-fix', [LancamentoController::class, 'saidasFixas']);
$router->get('/relatorios', [RelatorioController::class,  'index']);
$router->get('/analises',  [RelatorioController::class,  'mensal']);

// API (backend pendente)
$router->post('/api/lancamentos',        [LancamentoController::class, 'store']);
$router->put('/api/lancamentos/{id}',    [LancamentoController::class, 'update']);
$router->delete('/api/lancamentos/{id}', [LancamentoController::class, 'destroy']);

// Guard: rotas protegidas exigem sessão autenticada
$uri  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$path = '/' . ltrim(substr($uri, strlen($base)), '/');

$lembrado = ($_COOKIE['revizzi_lembrar'] ?? '') === '1';
if ($lembrado) {
    $_SESSION['autenticado'] = true;
}

if ($path !== '/login' && empty($_SESSION['autenticado'])) {
    header('Location: login');
    exit;
}

$router->dispatch();
