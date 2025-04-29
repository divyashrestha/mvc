<?php

namespace divyashrestha\Mvc\db;

use divyashrestha\Mvc\Application;
use PDOStatement;
use stdClass;

/**
 * Class BaseModel
 *
 * @author  Divya Shrestha <work@divyashrestha.com.np>
 * @package divyashrestha\Mvc\db
 */
abstract class BaseModel extends Model
{
    /**
     * @return string
     */
    abstract public static function tableName(): string;

    /**
     * @return string
     */
    public static function primaryKey(): string
    {
        return 'id';
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (" . implode(",", $attributes) . ") 
                VALUES (" . implode(",", $params) . ")");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;
    }

    /**
     * @param string $sql
     * @return PDOStatement
     */
    public static function prepare(string $sql): PDOStatement
    {
        return Application::$app->db->prepare($sql);
    }

    /**
     * @param array $where
     * @return mixed
     */
    public static function findOne(array $where): mixed
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }
}