<?php

namespace divyashrestha\Mvc\db;

abstract class BaseMigration
{
    abstract public function up(): void;

    abstract public function down(): void;
}
