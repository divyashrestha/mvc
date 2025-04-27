<?php

namespace divyashrestha\Mvc;

/**
 * Class Response
 *
 * @author  Divya Shrestha <work@divyashrestha.com.np>
 * @package divyashrestha\Mvc
 */
class Response
{
    /**
     * @param int $code
     * @return void
     */
    public function statusCode(int $code): void
    {
        http_response_code($code);
    }

    /**
     * @param $url
     * @return void
     */
    public function redirect($url): void
    {
        header("Location: $url");
    }
}