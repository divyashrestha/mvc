<?php
/**
 * User: TheCodeholic
 * Date: 7/8/2020
 * Time: 8:43 AM
 */

namespace divyashrestha\mvc;

use divyashrestha\mvc\middlewares\BaseMiddleware;
/**
 * Class Controller
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
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