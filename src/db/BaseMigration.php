<?php

namespace divyashrestha\Mvc\db;

/**
 * abstract class BaseMigration
 *
 * @author Divya Shrestha <work@divyashrestha.com.np>
 * @package divyashrestha\Mvc
 *
 */
abstract class BaseMigration
{
    /**
     * @return void
     */
    abstract public function up(): void;

    /**
     * @return void
     */
    abstract public function down(): void;
}
