<?php
namespace Crmlva\Exposy;

abstract class Controller 
{
    const REQUEST_METHOD_GET = "GET";
    const REQUEST_METHOD_POST = "POST";

    protected function getData(): array
    {
        return $this->isRequestMethod(self::REQUEST_METHOD_POST) ? $_POST : $_GET;
    }

    protected function isRequestMethod(string $method): bool
    {
        return $_SERVER['REQUEST_METHOD'] === $method;
    }

    public function redirect(string $target): void
    {
        header("Location: {$target}");
        exit();
    }

    public function error(int $code): void
    {
        http_response_code($code);
        (new View('error', $code));
    }

    protected function renderView(string $view, array $data = []): void
    {
        // Extract errors and success messages
        $errors = $_SESSION['errors'] ?? [];
        $success = $_SESSION['success'] ?? '';

        // Clear errors and success after use
        unset($_SESSION['errors']);
        unset($_SESSION['success']);

        // Pass data and errors to the view
        $data['errors'] = $errors;
        $data['success'] = $success;

        // Render view with data
        new View('layout', $view, $data);
    }
}
