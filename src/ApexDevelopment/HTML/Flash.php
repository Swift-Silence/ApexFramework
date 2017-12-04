<?php

/**
 * Flash HTML Object
 *
 * Allows for errors and success messages to be set an then can be used on the
 * front end.
 */

namespace ApexDevelopment\HTML;

class Flash
{

    /**
     * All of the success messages.
     * @var array
     */
    private $success = [];

    /**
     * All of the notification messages.
     * @var array
     */
    private $notification = [];

    /**
     * All of the error messages.
     * @var array
     */
    private $error = [];

    /**
     * Adds a new success message.
     * @param string $msg The message to add.
     */
    public function setSuccess($msg)
    {
        $this -> success[] = $msg;
    }

    /**
     * Adds a new notification message.
     * @param string $msg The message to add.
     */
    public function setNotification($msg)
    {
        $this -> notification[] = $msg;
    }

    /**
     * Adds a new error message.
     * @param string $msg The message to add.
     */
    public function setError($msg)
    {
        $this -> error[] = $msg;
    }

    /**
     * Returns all success messages, if there are any.
     * @return string content
     */
    public function success()
    {
        if (!$this -> isSuccess())
        {
            return "";
        }

        $str = '<div id="flash-success">';

        foreach($this -> success as $msg)
        {
            $str .= "<p>{$msg}</p>";
        }

        $str .= '</div>';

        return $str;
    }

    /**
     * Returns all notification messages, if there are any.
     * @return string content
     */
    public function notification()
    {
        if (!$this -> isNotification())
        {
            return "";
        }

        $str = '<div id="flash-notification">';

        foreach($this -> notification as $msg)
        {
            $str .= "<p>{$msg}</p>";
        }

        $str .= '</div>';

        return $str;
    }

    /**
     * Returns all error messages, if there are any.
     * @return string content
     */
    public function error()
    {
        if (!$this -> isError())
        {
            return "";
        }

        $str = '<div id="flash-error">';

        foreach($this -> error as $msg)
        {
            $str .= "<p>{$msg}</p>";
        }

        $str .= '</div>';

        return $str;
    }

    /**
     * Tests if there are success messages.
     * @return boolean Whether or not there are messages.
     */
    private function isSuccess()
    {
        if (!empty($this -> success))
        {
            return true;
        }

        return false;
    }

    /**
     * Tests if there are notification messages.
     * @return boolean Whether or not there are messages.
     */
    private function isNotification()
    {
        if (!empty($this -> notification))
        {
            return true;
        }

        return false;
    }

    /**
     * Tests if there are error messages.
     * @return boolean Whether or not there are messages.
     */
    private function isError()
    {
        if (!empty($this -> error))
        {
            return true;
        }

        return false;
    }

}
