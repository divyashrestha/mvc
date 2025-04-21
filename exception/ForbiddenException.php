<?php

/**
 * User: Divya Shrestha <work@divyashrestha.com.np>
 * Date: 21/04/2025
 * Time: 21:17
 */

namespace divyashrestha\mvc\exception;

use divyashrestha\mvc\Application;

/**
 * Class ForbiddenException
 *
 * @author  Divya Shrestha <work@divyashrestha.com.np>
 * @package divyashrestha\mvc\exception
 */
class ForbiddenException extends \Exception
{
    protected $message = 'You don\'t have permission to access this page';
    protected $code = 403;
}