<?php

namespace divyashrestha\Mvc\exception;

/**
 * Class NotFoundException
 *
 * @author  Divya Shrestha <work@divyashrestha.com.np>
 * @package divyashrestha\Mvc\exception
 */
class NotFoundException extends BaseException
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