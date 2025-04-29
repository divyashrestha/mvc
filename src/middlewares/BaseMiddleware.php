<?php

namespace divyashrestha\Mvc\middlewares;

/**
 * Class BaseMiddleware
 *
 * @author  Divya Shrestha <work@divyashrestha.com.np>
 * @package divyashrestha\Mvc
 */
abstract class BaseMiddleware
{
    /**
     * @return void
     */
    abstract public function execute(): void;
}
