<?php
/**
 * User: TheCodeholic
 * Date: 7/7/2020
 * Time: 10:53 AM
 */

namespace divyashrestha\mvc;


/**
 * Class Response
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package divyashrestha\mvc
 */
class Response
{
    public function statusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect($url)
    {
        header("Location: $url");
    }
}