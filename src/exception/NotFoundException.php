<?php


namespace divyashrestha\Mvc\exception;

use Exception;

/**
 * Class NotFoundException
 *
 * @author  Divya Shrestha <work@divyashrestha.com.np>
 * @package divyashresthaMvc\exception
 */
class NotFoundException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'Page not found';
    /**
     * @var int
     */
    protected $code = 404;
}