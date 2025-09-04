<?php

namespace core\Session;

use traits\Logger\Logger;

class Session
{

    use Logger;

    private static $instance = null;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            $this->logmessage("New session Started ...");
        } else {
            $this->logmessage("Session already active !!!");
        }
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function setSessionValue(string $key, $value)
    {
        $_SESSION[$key] = $value;
        $this->logmessage("new session value added for : $key => $value ...");
    }

    public function setSessionArrayValue(String $key, $value)
    {

        if (!$this->has($key)) {
            $_SESSION[$key] = [];
            $this->logmessage("new session Key created for array : $key ...");
        }

        if (is_array($value)) {
            $isAssociative = array_keys($value) !== range(0, count($value) - 1);
            if ($isAssociative) {

                $_SESSION[$key] = array_replace($_SESSION[$key], $value);
                $this->logmessage("new session array value added for : $key => " . print_r($value, true) . " ...");
            } else {

                $_SESSION[$key] = array_merge($_SESSION[$key], $value);
                $this->logmessage("new session array value added for : $key => " . print_r($value, true) . " ...");
            }
        } else {
            $_SESSION[$key][] = $value;
            $this->logmessage("new session value added in array : $key => $value ...");
        }
    }

    public function getSessionValue(string $key)
    {
        $this->logmessage("fetching session value for $key => " . (isset($_SESSION[$key]) ? print_r($_SESSION[$key], true) : "no value!!!"));
        return $_SESSION[$key] ?? null;
    }


    public function has(string $key): bool
    {
        $isset = isset($_SESSION[$key]);
        $this->logmessage($isset ? "$key is available ..." : "$key is not available !!!");
        return $isset;
    }

    public function remove_Session_Array_Value(string $key,  $value)
    {
        foreach ($_SESSION[$key] as $index => $item) {
            if ($item == $value) {
                unset($_SESSION[$key][$index]);
                $this->logmessage("value unset for $key=> $index");
            }
        }
    }

    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
        $this->logmessage("value unset for $key");
    }


    public function destroySession(): void
    {
        $_SESSION = [];
        session_destroy();
        $this->logmessage("Session destroyed !!!");
    }
}
