<?php

namespace divyashrestha\Mvc;

use divyashrestha\Mvc\middlewares\BaseMiddleware;

/**
 * Class Controller
 *
 * @author  Divya Shrestha <work@divyashrestha.com.np>
 * @package divyashrestha\Mvc
 */
class Controller
{
    /**
     * @var string
     */
    public string $layout = 'main';
    /**
     * @var string
     */
    public string $action = '';
    /**
     * @var array
     */
    protected array $middlewares = [];

    /**
     * @param string $layout
     * @return void
     */
    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    /**
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render(string $view, array $params = []): string
    {
        return Application::$app->router->renderView($view, $params);
    }

    /**
     * @param BaseMiddleware $middleware
     * @return void
     */
    public function registerMiddleware(BaseMiddleware $middleware): void
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * @return array
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}