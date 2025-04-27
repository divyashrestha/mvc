<?php

namespace divyashrestha\Mvc\exception;

use Exception;

/**
 * Class ForbiddenException
 *
 * @author  Divya Shrestha <work@divyashrestha.com.np>
 * @package divyashresthaMvc\exception
 */
class ForbiddenException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'You don\'t have permission to access this page';
    /**
     * @var int
     */
    protected $code = 403;
}