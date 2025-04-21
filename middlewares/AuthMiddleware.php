<?php
/**
 * User: TheCodeholic
 * Date: 7/25/2020
 * Time: 11:33 AM
 */

namespace divyashrestha\mvc\middlewares;


use divyashrestha\mvc\Application;
use divyashrestha\mvc\exception\ForbiddenException;

/**
 * Class AuthMiddleware
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
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