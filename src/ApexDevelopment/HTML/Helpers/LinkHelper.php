<?php

// The HTML Link helper

namespace ApexDevelopment\HTML\Helpers;

use ApexDevelopment\HTML\Helper;

class LinkHelper extends Helper
{

    // Creates a link.
    public function create($visibleName, $href, array $params = [])
    {
        $str = '<a href="' . $href . '" ';

        $str .= $this -> parseAttr($params) . '>' . $visibleName . '</a>';

        return $str;
    }

}
