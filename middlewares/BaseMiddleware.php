<?php
/**
 * User: TheCodeholic
 * Date: 7/25/2020
 * Time: 11:33 AM
 */

namespace divyashrestha\mvc\middlewares;


/**
 * Class BaseMiddleware
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package divyashrestha\mvc
 */
abstract class BaseMiddleware
{
    abstract public function execute();
}