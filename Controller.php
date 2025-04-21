<?php

/**
 * User: Divya Shrestha <work@divyashrestha.com.np>
 * Date: 21/04/2025
 * Time: 21:17
 */
namespace divyashrestha\mvc;

use divyashrestha\mvc\middlewares\BaseMiddleware;

/**
 * Class Controller
 *
 * @author  Divya Shrestha <work@divyashrestha.com.np>
 * @package divyashrestha\mvc
 */
class Controller
{
    public string $layout = 'main';
    public string $action = '';

    /**
     * @var \divyashrestha\mvc\BaseMiddleware[]
     */
    protected array $middlewares = [];

    public function setLayout($layout): void
    {
        $this->layout = $layout;
    }

    public function render($view, $params = []): string
    {
        return Application::$app->router->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * @return \divyashrestha\mvc\middlewares\BaseMiddleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}