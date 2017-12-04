<?php

// The HTML Form helper

namespace ApexDevelopment\HTML\Helpers;

use ApexDevelopment\HTML\Helper;
use ApexDevelopment\PHP\ClassRegistry;

class FormHelper extends Helper
{

    private $Request = null;

    public function __construct()
    {
        $cr = ClassRegistry::singleton();

        $this -> Request = $cr -> pull('Request');
    }

    // Creates a form
    public function create($method, $action, array $params = [])
    {
        $str = '<form method="' . strtoupper($method) . '" action="' . $action . '" ';
        $str .= $this -> parseAttr($params) . '>';

        return $str;
    }

    public function hidden($name, $val)
    {
        $str = '<input type="hidden" name="' . $name . '" value= "' . $val . '" ';
        $str .= $this -> parseAttr($params) . ' />';

        return $str;
    }

    // Creates a text box
    public function textbox($name, array $params = [])
    {
        if ($val = $this -> Request -> post($name))
        {
            $params['value'] = $val;
        }

        $str = '<input type="text" name="' . $name . '" ';
        $str .= $this -> parseAttr($params) . '/>';

        return $str;
    }

    public function password($name, array $params = [])
    {
        $str = '<input type="password" name="' . $name . '" ';
        $str .= $this -> parseAttr($params) . '/>';

        return $str;
    }

    // Creates a text area
    public function textarea($name, array $params = [])
    {
        if ($val = $this -> Request -> post($name))
        {
            $params['tavalue'] = $val;
        }

        $str = '<textarea name="' . $name . '" ';
        $str .= $this -> parseAttr($params) . '>';

        if (isset($params['tavalue']))
        {
            $str .= $params['tavalue'];
        }

        $str .= "</textarea>";

        return $str;
    }

    // Creates a checkbox
    public function checkbox($name, $value, array $params = [])
    {
        if ($val = $this -> Request -> post($name))
        {
            if ($val == $value)
            {
                $params['checked'] = true;
            }
        }

        $str = '<input type="checkbox" name="' . $name . '" value="' . $value . '" ';
        $str .= $this -> parseAttr($params) . '/>';

        return $str;
    }

    // Opens a dropdown menu
    public function dropdown($name, array $params = [])
    {
        $str = '<select name="' . $name . '" ';
        $str .= $this -> parseAttr($params) . '>';

        return $str;
    }

    // Ends a dropdown menu
    public function dropdownEnd()
    {
        return "</select>";
    }

    // Adds a dropdown menu option.
    public function option($parentName, $text, $value, array $params = [])
    {
        if ($val = $this -> Request -> post($parentName))
        {
            if ($val == $value)
            {
                $params['selected'] = true;
            }
        }

        $str = '<option value="' . $value . '" ';
        $str .= $this -> parseAttr($params) . '>' . $text . '</option>';

        return $str;
    }

    // Creates a radio button
    public function radioButton($name, $value, array $params = [])
    {
        if ($val = $this -> Request -> post($name))
        {
            if ($val == $value)
            {
                $params['checked'] = true;
            }
        }

        $str = '<input type="radio" name="' . $name . '" value="' . $value . '" ';
        $str .= $this -> parseAttr($params) . '/>';

        return $str;
    }

    // Creates a submit button
    public function submit($text, $name, array $params = [])
    {
        $str = '<input type="submit" name="' . $name . '" value="' . $text . '" ';
        $str .= $this -> parseAttr($params) . '/>';

        return $str;
    }

    // Ends the form
    public function end()
    {
        return '</form>';
    }

}
