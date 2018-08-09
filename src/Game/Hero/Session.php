<?php

namespace App\Game\Hero;

class Session
{

    /**
     * Session constructor.
     */
    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    /**
     * @param $key
     * @param $val
     */
    public function set($key, $val)
    {
        $_SESSION[$key] = $val;
    }

    /**
     * @param $key
     * @param $val
     */
    public function saveCharacter($key, $val)
    {
        $_SESSION['character'][$key] = $val;
    }


    /**
     * @param $key
     * @return mixed
     */
    public function getCharacter($key)
    {
        if (isset($_SESSION['character'][$key])) {
            return $_SESSION['character'][$key];
        }
    }

    /**
     * @return array|null
     */
    public function getCharacters()
    {
        foreach ($_SESSION['character'] as $character) {
            $game[] = $character;
        }
        return $game??null;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }


    public function clearStorage()
    {
        session_destroy();
    }

}