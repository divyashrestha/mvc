<?php

/**
 * User: Divya Shrestha <work@divyashrestha.com.np>
 * Date: 21/04/2025
 * Time: 21:17
 */

namespace divyashrestha\mvc;

use divyashrestha\mvc\db\DbModel;

/**
 * Class UserModel
 *
 * @author  Divya Shrestha <work@divyashrestha.com.np>
 * @package divyashrestha\mvc
 */
abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}