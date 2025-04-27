<?php

namespace divyashrestha\Mvc;

/**
 * Class View
 *
 * @author  Divya Shrestha <work@divyashrestha.com.np>
 * @package divyashrestha\Mvc
 */
class View
{
    /**
     * @var string
     */
    public string $title = '';

    /**
     * @param $view
     * @param array $params
     * @return array|false|string
     */
    public function renderView($view, array $params): array|false|string
    {
        $layoutName = Application::$app->layout;
        if (Application::$app->controller) {
            $layoutName = Application::$app->controller->layout;
        }
        $viewContent = $this->renderViewOnly($view, $params);
        ob_start();
        include_once Application::$ROOT_DIR . "/app/views/layouts/$layoutName.php";
        $layoutContent = ob_get_clean();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     * @param string $view
     * @param array $params
     * @return false|string
     */
    public function renderViewOnly(string $view, array $params): false|string
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR . '/app/views/' . str_replace('.', '/', $view) . '.php';
        return ob_get_clean();
    }

    /**
     * @param string $folder
     * @param string $view
     * @param array $params
     * @return void
     */
    public function load_partial(string $folder, string $view, array $params = []): void
    {
        print_r($this->renderViewOnly("$folder/_$view", $params));
    }
}