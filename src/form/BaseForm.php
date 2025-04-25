<?php

/**
 * User: Divya Shrestha <work@divyashrestha.com.np>
 * Date: 21/04/2025
 * Time: 21:17
 */

namespace divyashrestha\Mvc\form;

use divyashrestha\Mvc\db\DbModel;

/**
 * Class BaseForm
 *
 * @author  Divya Shrestha <work@divyashrestha.com.np>
 * @package core\form
 */
abstract class BaseForm
{
    public function __construct($action, $method, $options = [])
    {
        $attributes = [];
        foreach ($options as $key => $value) {
            $attributes[] = "$key=\"$value\"";
        }
        echo sprintf('<form action="%s" method="%s" %s>', $action, $method, implode(" ", $attributes));
    }

    public static function end(): void
    {
        echo '</form>';
    }


    public function button($type, $label, $options = []): string
    {
        $optional_attributes = [];
        foreach ($options as $key => $value) {
            $optional_attributes[] = "$key=\"$value\"";
        }
        return sprintf('<button type="%s" %s>%s</button>',
            $type,
            implode(" ", $optional_attributes),
            $label,
        );
    }

}