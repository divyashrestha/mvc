<?php

/**
 * User: Divya Shrestha <work@divyashrestha.com.np>
 * Date: 21/04/2025
 * Time: 21:17
 */

namespace divyashrestha\Mvc;

use divyashrestha\Mvc\db\Database;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Class Application
 *
 * @author  Divya Shrestha <work@divyashrestha.com.np>
 * @package app
 */
class Application
{
    const EVENT_BEFORE_REQUEST = 'beforeRequest';
    const EVENT_AFTER_REQUEST = 'afterRequest';

    protected array $eventListeners = [];

    public static Application $app;
    public static string $ROOT_DIR;
    public string $layout = 'main';
    public Router $router;
    public Request $request;
    public Response $response;
    public ?Controller $controller = null;
    public Database $db;
    public array $app_config;
    public Session $session;
    public View $view;
    public ?UserModel $user;

    public function __construct($rootDir, $config)
    {
        $this->user = null;
        self::$ROOT_DIR = $rootDir;
        self::$app = $this;
        $this->loadDirectory('app/helpers');
        $this->loadDirectory('migrations');
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);
        $this->app_config = $config['app'];
        $this->session = new Session();
        $this->view = new View();
    }

    public function run(): void
    {
        $this->triggerEvent(self::EVENT_BEFORE_REQUEST);
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            echo $this->router->renderView('_error', [
                'exception' => $e,
            ]);
        }
    }

    public function triggerEvent($eventName): void
    {
        $callbacks = $this->eventListeners[$eventName] ?? [];
        foreach ($callbacks as $callback) {
            call_user_func($callback);
        }
    }

    public function on($eventName, $callback): void
    {
        $this->eventListeners[$eventName][] = $callback;
    }

    public static function basicAuth(): bool
    {
        return self::$app->app_config['app_env'] == 'staging';
    }
    public static function  log($message): void
    {
        echo "[" . date("Y-m-d H:i:s") . "] - " . $message . PHP_EOL;
    }

    public function loadDirectory($directory): void
    {
        $folderPath= self::$ROOT_DIR ."/$directory";
        if (!is_dir($folderPath)) {
            die("Invalid folder path: $folderPath");
        }

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folderPath));

        foreach ($iterator as $file) {
            if ($file->isFile() && pathinfo($file, PATHINFO_EXTENSION) === "php") {
                require_once $file->getPathname();
            }
        }

    }
}