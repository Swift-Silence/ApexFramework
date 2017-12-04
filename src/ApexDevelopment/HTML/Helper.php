<?php

// The helpers parent

namespace ApexDevelopment\HTML;

class Helper
{

    // Parses the class and ID names of parameters if they are given.
    protected function parseAttr($params)
    {
        $str = "";

        if (isset($params['value']))
        {
            $str .= 'value="' . $params['value'] . '" ';
        }

        if (isset($params['tooltip']))
        {
            $str .= 'title="' . $params['tooltip'] . '" ';
        }

        if (isset($params['placeholder']))
        {
            $str .= 'placeholder="' . $params['placeholder'] . '" ';
        }

        if (isset($params['rows']))
        {
            $str .= 'rows="' . $params['rows'] . '" ';
        }

        if (isset($params['cols']))
        {
            $str .= 'cols="' . $params['cols'] . '" ';
        }

        if (isset($params['class']))
        {
            $str .= 'class="';
            $classes = explode(',', $params['class']);

            foreach ($classes as $class)
            {
                $class = trim($class);
                $str .= "$class ";
            }

            $str = substr($str, 0, -1) . '" ';
        }

        if (isset($params['id']))
        {
            $str .= 'id="';
            $IDs = explode(',', $params['id']);

            foreach ($IDs as $ID)
            {
                $ID = trim($ID);
                $str .= "$ID ";
            }

            $str = substr($str, 0, -1) . '" ';
        }

        if (isset($params['selected']))
        {
            $str .= 'selected="selected" ';
        }

        if (isset($params['checked']))
        {
            $str .= 'checked ';
        }

        return substr($str, 0, -1);
    }

}
