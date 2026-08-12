<?php
declare(strict_types=1);

header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: strict-origin-when-cross-origin');
// script-src precisa de 'unsafe-inline' porque as views usam <script> inline (ex.: orcamentos/index.php).
// Ideal a médio prazo: mover esses scripts para arquivos externos e trocar por nonce.
header("Content-Security-Policy: default-src 'self'; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src https://fonts.gstatic.com; img-src 'self' data:; script-src 'self' 'unsafe-inline'");

session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/app/Core/Router.php';
require_once __DIR__ . '/app/Core/RememberMe.php';
require_once __DIR__ . '/app/Controllers/Controller.php';
require_once __DIR__ . '/app/Models/Lancamento.php';
require_once __DIR__ . '/app/Models/Orcamento.php';
require_once __DIR__ . '/app/Controllers/AuthController.php';
require_once __DIR__ . '/app/Controllers/LancamentoController.php';
require_once __DIR__ . '/app/Controllers/RelatorioController.php';
require_once __DIR__ . '/app/Controllers/OrcamentoController.php';

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
$router->get('/orcamentos', [OrcamentoController::class, 'index']);

// API (backend pendente)
$router->post('/api/lancamentos',        [LancamentoController::class, 'store']);
$router->put('/api/lancamentos/{id}',    [LancamentoController::class, 'update']);
$router->delete('/api/lancamentos/{id}', [LancamentoController::class, 'destroy']);

$router->get('/api/orcamentos',         [OrcamentoController::class, 'listar']);
$router->get('/api/orcamentos/{id}',    [OrcamentoController::class, 'show']);
$router->post('/api/orcamentos',        [OrcamentoController::class, 'store']);
$router->delete('/api/orcamentos/{id}', [OrcamentoController::class, 'destroy']);

// Guard: rotas protegidas exigem sessão autenticada
$uri  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$path = '/' . ltrim(substr($uri, strlen($base)), '/');

if (RememberMe::valido()) {
    $_SESSION['autenticado'] = true;
}

if ($path !== '/login' && empty($_SESSION['autenticado'])) {
    header('Location: login');
    exit;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$router->dispatch();
