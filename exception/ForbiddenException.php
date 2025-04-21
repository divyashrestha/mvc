<?php
/**
 * User: TheCodeholic
 * Date: 7/25/2020
 * Time: 11:35 AM
 */

namespace divyashrestha\mvc\exception;


use divyashrestha\mvc\Application;

/**
 * Class ForbiddenException
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package divyashrestha\mvc\exception
 */
class ForbiddenException extends \Exception
{
    protected $message = 'You don\'t have permission to access this page';
    protected $code = 403;
}