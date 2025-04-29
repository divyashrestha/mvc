<?php

namespace divyashrestha\Mvc\db;

use divyashrestha\Mvc\Application;
use PDO;
use PDOStatement;

/**
 * Class Database
 *
 * @author  Divya Shrestha <work@divyashrestha.com.np>
 * @package divyashrestha\Mvc\db
 */
class Database
{
    /**
     * @var PDO
     */
    public PDO $pdo;

    /**
     * @param array $dbConfig
     */
    public function __construct(array $dbConfig = [])
    {
        $dbDsn = $dbConfig['dsn'] ?? '';
        $username = $dbConfig['user'] ?? '';
        $password = $dbConfig['password'] ?? '';

        $this->pdo = new PDO($dbDsn, $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @return void
     */
    public function applyMigrations(): void
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $newMigrations = [];
        $files = scandir(Application::$ROOT_DIR . '/migrations');
        $toApplyMigrations = array_diff($files, $appliedMigrations);
        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }

            require_once Application::$ROOT_DIR . '/migrations/' . $migration;
            $className = 'migrations\\' . pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            log_message("Applying migration $migration");
            $instance->up();
            log_message("Applied migration $migration");
            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            log_message("There are no migrations to apply");
        }
    }

    /**
     * @return void
     */
    protected function createMigrationsTable(): void
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )  ENGINE=INNODB;");
    }

    /**
     * @return array
     */
    protected function getAppliedMigrations(): array
    {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * @param array $newMigrations
     * @return void
     */
    protected function saveMigrations(array $newMigrations): void
    {
        $str = implode(',', array_map(fn($m) => "('$m')", $newMigrations));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $str ");
        $statement->execute();
    }

    /**
     * @param string $sql
     * @return PDOStatement
     */
    public function prepare(string $sql): PDOStatement
    {
        return $this->pdo->prepare($sql);
    }
}