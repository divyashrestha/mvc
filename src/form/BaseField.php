<?php

namespace divyashrestha\Mvc\form;

use divyashrestha\Mvc\db\BaseModel;
use divyashrestha\Mvc\db\Model;

/**
 * Class BaseField
 *
 * @author  Divya Shrestha <work@divyashrestha.com.np>
 * @package divyashrestha\Mvc\form
 */
abstract class BaseField
{
    /**
     * @var BaseModel|Model
     */
    public Model|BaseModel $model;
    /**
     * @var string
     */
    public string $attribute;
    /**
     * @var bool
     */
    public bool $required;
    /**
     * @var array
     */
    public array $optional_attribute;
    /**
     * @var string
     */
    public string $type;
    /**
     * @var string
     */
    public string $field_name;
    /**
     * @var string
     */
    public string $field_id;
    /** */
    const string TYPE_TEXT = 'text';
    /** */
    const string TYPE_PASSWORD = 'password';
    /** */
    const string TYPE_FILE = 'file';
    /** */
    const string TYPE_EMAIL = 'email';

    /**
     * BaseField constructor.
     *
     * @param BaseModel $model
     * @param string $attribute
     * @param bool $required
     * @param array $optional_attributes
     */
    public function __construct(BaseModel $model, string $attribute, bool $required, array $optional_attributes)
    {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->required = $required;
        $this->optional_attribute = $optional_attributes;
        $this->type = self::TYPE_TEXT;
        $this->field_name = "[" . $model->tableName() . "][$attribute]";
        $this->field_id = $model->tableName() . "_$attribute";
    }

    /**
     * @return mixed
     */
    abstract function __toString();


    /**
     * @return string
     */
    abstract function renderLabel(): string;

    /**
     * @return string
     */
    abstract function renderInput(): string;


    /**
     * @return $this
     */
    public function passwordField(): static
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    /**
     * @return $this
     */
    public function fileField(): static
    {
        $this->type = self::TYPE_FILE;
        return $this;
    }

    /**
     * @return $this
     */
    public function emailField(): static
    {
        $this->type = self::TYPE_EMAIL;
        return $this;
    }
}