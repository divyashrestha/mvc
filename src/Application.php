<?php

namespace divyashrestha\Mvc;

use divyashrestha\Mvc\db\Database;
use divyashrestha\Mvc\exception\ForbiddenException;
use divyashrestha\Mvc\exception\NotFoundException;
use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Class Application
 *
 * @author  Divya Shrestha <work@divyashrestha.com.np>
 * @package divyashrestha\Mvc
 */
class Application
{
    /** */
    const string EVENT_BEFORE_REQUEST = 'beforeRequest';
    /** */
    const string EVENT_AFTER_REQUEST = 'afterRequest';
    /**
     * @var array
     */
    protected array $eventListeners = [];
    /**
     * @var Application
     */
    public static Application $app;
    /**
     * @var string
     */
    public static string $ROOT_DIR;
    /**
     * @var string
     */
    public string $layout = 'main';
    /**
     * @var Router
     */
    public Router $router;
    /**
     * @var Request
     */
    public Request $request;
    /**
     * @var Response
     */
    public Response $response;
    /**
     * @var Controller|null
     */
    public ?Controller $controller = null;
    /**
     * @var Database
     */
    public Database $db;
    /**
     * @var array|mixed
     */
    public array $app_config;
    /**
     * @var array|mixed
     */
    public array $mail_config;
    /**
     * @var Session
     */
    public Session $session;
    /**
     * @var View
     */
    public View $view;

    /**
     * @param string $rootDir
     * @param array $config
     */
    public function __construct(string $rootDir, array $config)
    {
        self::$ROOT_DIR = $rootDir;
        self::$app = $this;
        $this->loadAppDirectory();
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);
        $this->app_config = $config['app'];
        $this->mail_config = $config['mail'];
        $this->session = new Session();
        $this->view = new View();
    }

    /**
     * @return void
     */
    private function loadAppDirectory(): void
    {
        $folders = ['controllers', 'helpers', 'middlewares'];
        $this->loadDirectory('migrations');
        foreach ($folders as $folder) {
            $this->loadDirectory("app/$folder");
        }
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $this->triggerEvent(self::EVENT_BEFORE_REQUEST);
        try {
            echo $this->router->resolve();
        } catch (NotFoundException $e) {
            $this->displayErrorPage($e, 'errors/not_found', ['exception' => $e,]);
        } catch (ForbiddenException $e) {
            $this->displayErrorPage($e, 'errors/forbidden', ['exception' => $e,]);
        } catch (Exception $e) {
            $this->displayErrorPage($e, 'errors/index', ['exception' => $e,]);
        }
    }

    /**
     * @param Exception $error
     * @param string $view
     * @param array $params
     * @return void
     */
    private function displayErrorPage(Exception $error, string $view, array $params): void
    {
        console_log($error->getMessage());
        echo $this->router->renderView($view, $params);
    }

    /**
     * @param $eventName
     * @return void
     */
    public function triggerEvent($eventName): void
    {
        $callbacks = $this->eventListeners[$eventName] ?? [];
        foreach ($callbacks as $callback) {
            call_user_func($callback);
        }
    }

    /**
     * @param $eventName
     * @param $callback
     * @return void
     */
    public function on($eventName, $callback): void
    {
        $this->eventListeners[$eventName][] = $callback;
    }

    /**
     * @return bool
     */
    public static function basicAuth(): bool
    {
        return self::$app->app_config['env'] == 'staging';
    }

    /**
     * @param $message
     * @return void
     */
    public static function log($message): void
    {
        echo "[" . date("Y-m-d H:i:s") . "] - " . $message . PHP_EOL;
    }

    /**
     * @param $directory
     * @return void
     */
    public function loadDirectory($directory): void
    {
        $folderPath = self::$ROOT_DIR . "/$directory";
        if (!is_dir($folderPath)) {
            exit;
        }

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folderPath));

        foreach ($iterator as $file) {
            if ($file->isFile() && pathinfo($file, PATHINFO_EXTENSION) === "php") {
                require_once $file->getPathname();
            }
        }

    }
}