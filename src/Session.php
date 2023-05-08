<?php

declare(strict_types=1);

namespace PsrPHP\Session;

class Session
{
    private $prefix = '';

    public function __construct(string $prefix = null)
    {
        if (is_null($prefix)) {
            $prefix = dirname('/' . implode('/', array_filter(
                explode('/', $_SERVER['SCRIPT_NAME']),
                function ($val) {
                    return strlen($val) > 0 ? true : false;
                }
            )));
        }
        $this->prefix = $prefix;
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public function set(string $name, $value): self
    {
        $_SESSION[$this->prefix . $name] = $value;
        return $this;
    }

    public function get(string $name, $default = null)
    {
        return isset($_SESSION[$this->prefix . $name]) ? $_SESSION[$this->prefix . $name] : $default;
    }

    public function delete(string $name): self
    {
        unset($_SESSION[$this->prefix . $name]);
        return $this;
    }

    public function has(string $name): bool
    {
        return isset($_SESSION[$this->prefix . $name]);
    }

    public function __set($name, $value)
    {
        $this->set($name, $value);
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function __unset($name)
    {
        $this->delete($name);
    }

    public function __isset($name)
    {
        return $this->has($name);
    }
}
