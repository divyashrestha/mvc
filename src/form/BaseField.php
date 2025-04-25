<?php

/**
 * User: Divya Shrestha <work@divyashrestha.com.np>
 * Date: 21/04/2025
 * Time: 21:17
 */

namespace divyashrestha\Mvc\form;

use divyashrestha\Mvc\db\DbModel;
use divyashrestha\Mvc\Model;

/**
 * Class BaseField
 *
 * @author  Divya Shrestha <work@divyashrestha.com.np>
 * @package divyashrestha\mvc\form
 */
abstract class BaseField
{
    public Model $model;
    public string $attribute;
    public string $required;
    public array $optional_attribute;
    public string $type;
    public string $field_name;
    public string $field_id;

    const string TYPE_TEXT = 'text';
    const string TYPE_PASSWORD = 'password';
    const string TYPE_FILE = 'file';
    const string TYPE_EMAIL = 'email';

    /**
     * Field constructor.
     *
     * @param DbModel $model
     * @param string $attribute
     */
    public function __construct(DbModel $model, string $attribute, $required, array $optional_attributes)
    {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->required = $required;
        $this->optional_attribute = $optional_attributes;
        $this->type = self::TYPE_TEXT;
        $this->field_name = "[" . $model->tableName() . "][$attribute]";
        $this->field_id = $model->tableName() . "_$attribute";
    }

    abstract function __toString();


    abstract function renderLabel(): string;
    abstract function renderInput(): string;


    public function passwordField(): static
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function fileField(): static
    {
        $this->type = self::TYPE_FILE;
        return $this;
    }
    public function emailField(): static
    {
        $this->type = self::TYPE_EMAIL;
        return $this;
    }
}