<?php

declare(strict_types=1);

namespace PsrPHP\Session;

class Session
{
    private $prefix = '';

    public function __construct(string $prefix = null)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $this->prefix = is_null($prefix) ? dirname('/' . implode('/', array_filter(
            explode('/', $_SERVER['SCRIPT_NAME']),
            function ($val) {
                return strlen($val) > 0 ? true : false;
            }
        ))) : $prefix;
    }

    public function set(string $name, $value)
    {
        $_SESSION[$this->prefix . $name] = serialize($value);
    }

    public function get(string $name, $default = null)
    {
        return isset($_SESSION[$this->prefix . $name]) ? unserialize($_SESSION[$this->prefix . $name]) : $default;
    }

    public function delete(string $name)
    {
        unset($_SESSION[$this->prefix . $name]);
    }

    public function has(string $name): bool
    {
        return isset($_SESSION[$this->prefix . $name]);
    }
}
