<?php

/**
 * User: Divya Shrestha <work@divyashrestha.com.np>
 * Date: 21/04/2025
 * Time: 21:17
 */

namespace divyashrestha\mvc\middlewares;


use divyashrestha\mvc\Application;
use divyashrestha\mvc\exception\ForbiddenException;

/**
 * Class AuthMiddleware
 *
 * @author  Divya Shrestha <work@divyashrestha.com.np>
 * @package divyashrestha\mvc
 */
class AuthMiddleware extends BaseMiddleware
{
    protected array $actions = [];

    public function __construct($actions = [])
    {
        $this->actions = $actions;
    }

    public function execute()
    {
        if (Application::isGuest()) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                throw new ForbiddenException();
            }
        }
    }
}