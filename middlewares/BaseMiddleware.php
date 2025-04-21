<?php

/**
 * User: Divya Shrestha <work@divyashrestha.com.np>
 * Date: 21/04/2025
 * Time: 21:17
 */

namespace divyashrestha\mvc\middlewares;


/**
 * Class BaseMiddleware
 *
 * @author  Divya Shrestha <work@divyashrestha.com.np>
 * @package divyashrestha\mvc
 */
abstract class BaseMiddleware
{
    abstract public function execute();
}