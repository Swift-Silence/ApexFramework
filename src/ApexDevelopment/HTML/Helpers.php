<?php

// The HTML helpers class

namespace ApexDevelopment\HTML;

use ApexDevelopment\HTML\Helpers\LinkHelper;
use ApexDevelopment\HTML\Helpers\FormHelper;

class Helpers
{

    // The helper class objects.
    public $Link = null,
           $Form = null;

    public function __construct()
    {
        $this -> Link = new LinkHelper();
        $this -> Form = new FormHelper();
    }
}
