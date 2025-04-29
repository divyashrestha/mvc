<?php

namespace divyashrestha\Mvc\exception;

/**
 * Class ForbiddenException
 *
 * @author  Divya Shrestha <work@divyashrestha.com.np>
 * @package divyashrestha\Mvc\exception
 */
class ForbiddenException extends BaseException
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