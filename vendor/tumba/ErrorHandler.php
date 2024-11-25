<?php

namespace tumba;

use JetBrains\PhpStorm\NoReturn;

class ErrorHandler
{

    public function __construct()
    {
        if (DEBUG) {
            error_reporting(E_ALL);
        } else {
            error_reporting(0);
        }
        set_exception_handler([$this, 'exceptionHandler']);
        set_error_handler([$this, 'errorHandler']);
        ob_start();
        register_shutdown_function([$this, 'shutdownHandler']);
    }


    #[NoReturn] public function exceptionHandler(\Throwable $e): void
    {
        $this->logError($e->getMessage(), $e->getFile(), $e->getLine());
        $this->displayError('Исключение', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
    }

    #[NoReturn] public function errorHandler($errNo, $errStr, $errFile, $errLine): void
    {
        $this->logError($errStr, $errFile, $errLine);
        $this->displayError($errNo, $errStr, $errFile, $errLine);
    }

    #[NoReturn] public function shutdownHandler(): void
    {
        $error = error_get_last();
        if (!empty($error) && $error['type'] & (E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR)) {
            $this->logError($error['message'], $error['file'], $error['line']);
            ob_end_clean();
            $this->displayError($error['type'], $error['message'], $error['file'], $error['line']);
        } else {
           ob_end_flush();
        }
    }

    protected function logError($message = '', $file = '', $line = ''): void
    {
        file_put_contents(
            LOGS . '/errors.log',
            "[" . date('Y-m-d H:i:s') . "] Текст ошибки: {$message} | Файл: {$file} | Строка {$line}\n",
            FILE_APPEND);
    }

    #[NoReturn] protected function displayError($errNo, $errStr, $errFile, $errLine, $response = 500): void
    {
        if ($response == 0) {
            $response = 404;
        }
        http_response_code($response);
        if ($response == 404 && !DEBUG) {
            require WWW . '/errors/404.php';
            die();
        }
        if (DEBUG) {
            require WWW . '/errors/development.php';
        } else {
            require WWW . '/errors/production.php';
        }
        die();
    }
}