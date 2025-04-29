<?php

namespace divyashrestha\Mvc\db;

use divyashrestha\Mvc\Application;

/**
 * Class Model
 *
 * @author  Divya Shrestha <work@divyashrestha.com.np>
 * @package divyashrestha\Mvc\db
 */
class Model
{
    /** */
    const string RULE_REQUIRED = 'required';
    /** */
    const string RULE_EMAIL = 'email';
    /** */
    const string RULE_MIN = 'min';
    /** */
    const string RULE_MAX = 'max';
    /** */
    const string RULE_MATCH = 'match';
    /** */
    const string RULE_UNIQUE = 'unique';
    /**
     * @var string
     */
    public string $created_at = '';
    /**
     * @var string
     */
    public string $updated_at = '';

    /**
     * @var array
     */
    public array $errors = [];

    /**
     * @param array $data
     * @return void
     */
    public function loadData(array $data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function labels(): array
    {
        return [];
    }

    /**
     * @param string $attribute
     * @return string
     */
    public function getLabel(string $attribute): string
    {
        return $this->labels()[$attribute] ?? $attribute;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($rule)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addErrorByRule($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorByRule($attribute, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addErrorByRule($attribute, self::RULE_MIN, ['min' => $rule['min']]);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addErrorByRule($attribute, self::RULE_MAX);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addErrorByRule($attribute, self::RULE_MATCH, ['match' => $rule['match']]);
                }
                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $db = Application::$app->db;
                    $statement = $db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :$uniqueAttr");
                    $statement->bindValue(":$uniqueAttr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if ($record) {
                        $this->addErrorByRule($attribute, self::RULE_UNIQUE);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    /**
     * @return string[]
     */
    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
            self::RULE_UNIQUE => 'Record with with this {field} already exists',
        ];
    }

    /**
     * @param string $rule
     * @return string
     */
    public function errorMessage(string $rule): string
    {
        return $this->errorMessages()[$rule];
    }

    /**
     * @param string $attribute
     * @param string $rule
     * @param array $params
     * @return void
     */
    protected function addErrorByRule(string $attribute, string $rule, array $params = []): void
    {
        $params['field'] ??= $attribute;
        $errorMessage = $this->errorMessage($rule);
        foreach ($params as $key => $value) {
            $errorMessage = str_replace("{{$key}}", $value, $errorMessage);
        }
        $this->errors[$attribute][] = $errorMessage;
    }

    /**
     * @param string $attribute
     * @param string $message
     * @return void
     */
    public function addError(string $attribute, string $message): void
    {
        $this->errors[$attribute][] = $message;
    }

    /**
     * @param string $attribute
     * @return false|mixed
     */
    public function hasError(string $attribute): mixed
    {
        return $this->errors[$attribute] ?? false;
    }

    /**
     * @param string $attribute
     * @return mixed|string
     */
    public function getFirstError(string $attribute): mixed
    {
        $errors = $this->errors[$attribute] ?? [];
        return $errors[0] ?? '';
    }
}