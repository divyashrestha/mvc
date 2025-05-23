<?php

namespace divyashrestha\Mvc;

/**
 * Class Request
 *
 * @author  Divya Shrestha <work@divyashrestha.com.np>
 * @package divyashrestha\Mvc
 */
class Request
{
    /**
     * @var array
     */
    private array $routeParams = [];

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @return string|null
     */
    public function getUrl(): null|string
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if ($position !== false) {
            $path = substr($path, 0, $position);
        }
        return $path;
    }

    /**
     * @return bool
     */
    public function isGet(): bool
    {
        return $this->getMethod() === 'get';
    }

    /**
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->getMethod() === 'post';
    }

    /**
     * @return bool
     */
    public function isPut(): bool
    {
        return $this->getMethod() === 'put';
    }

    /**
     * @return bool
     */
    public function isPatch(): bool
    {
        return $this->getMethod() === 'patch';
    }

    /**
     * @return bool
     */
    public function isDelete(): bool
    {
        return $this->getMethod() === 'delete';
    }

    /**
     * @param bool $method
     * @return array
     */
    public function getBody(bool $method= false): array
    {
        $data = [];
        if($method){
            $data['method'] = $this->getMethod();
        }
        if ($this->isGet()) {
            foreach ($_GET as $key => $value) {
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->isPost() || $this->isPut() || $this->isPatch() || $this->isDelete()) {
            foreach ($_POST as $key => $value) {
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $data;
    }

    /**
     * @param array $params
     * @return self
     */
    public function setRouteParams(array $params): static
    {
        $this->routeParams = $params;
        return $this;
    }

    /**
     * @return array
     */
    public function getRouteParams(): array
    {
        return $this->routeParams;
    }

    /**
     * @param string $param
     * @param string|null $default
     * @return null|string
     */
    public function getRouteParam(string $param, null|string $default = null): null|string
    {
        return $this->routeParams[$param] ?? $default;
    }
}
