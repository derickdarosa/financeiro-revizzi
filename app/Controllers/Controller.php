<?php
declare(strict_types=1);

abstract class Controller
{
    protected function render(string $view, array $data = []): void
    {
        extract($data);
        $extraStyles  = '';
        $extraScripts = '';

        ob_start();
        include __DIR__ . '/../Views/' . $view . '.php';
        $conteudo = ob_get_clean();

        include __DIR__ . '/../Views/layouts/main.php';
    }

    protected function json(mixed $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}
