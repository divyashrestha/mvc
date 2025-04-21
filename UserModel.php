<?php
/**
 * User: TheCodeholic
 * Date: 7/25/2020
 * Time: 10:13 AM
 */

namespace divyashrestha\mvc;

use divyashrestha\mvc\db\DbModel;

/**
 * Class UserModel
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package divyashrestha\mvc
 */
abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}