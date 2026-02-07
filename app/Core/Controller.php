<?php
declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        $viewFile = __DIR__ . '/../../views/' . $view . '.php';
        if (!is_file($viewFile)) {
            http_response_code(500);
            echo "View not found: " . htmlspecialchars($view);
            return;
        }

        require __DIR__ . '/../../views/layout/header.php';
        require $viewFile;
        require __DIR__ . '/../../views/layout/footer.php';
    }

    protected function jsonResponse(bool $ok, array $data = [], string $error = '', int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        
        $response = [
            'ok' => $ok,
        ];

        if ($ok) {
            $response['data'] = $data;
        } else {
            $response['error'] = $error;
        }

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
