<?php
namespace divyashrestha\Mvc\form;

/**
 * Class BaseForm
 *
 * @author  Divya Shrestha <work@divyashrestha.com.np>
 * @package divyashrestha\Mvc\form
 */

abstract class BaseForm
{
    /**
     * @param string $action
     * @param string $method
     * @param array $options
     */
    public function __construct(string $action, string $method, array $options = [])
    {
        $attributes = [];
        foreach ($options as $key => $value) {
            $attributes[] = "$key=\"$value\"";
        }
        echo sprintf('<form action="%s" method="%s" %s>', $action, $method, implode(" ", $attributes));
    }

    /**
     * @return void
     */
    public static function end(): void
    {
        echo '</form>';
    }


    /**
     * @param string $type
     * @param string $label
     * @param array $options
     * @return string
     */
    public function button(string $type, string $label,array $options = []): string
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