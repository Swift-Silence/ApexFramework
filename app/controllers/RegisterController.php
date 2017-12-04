<?php

namespace Controllers;

use ApexDevelopment\Core\Controller;

class RegisterController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $this -> Auth -> deny('authorized');
        $this -> Auth -> filter();
    }

    public function index($params)
    {
        if ($this -> Request -> isPost())
        {
            if (!$this -> Auth -> register($this -> Request -> post()))
            {
                $this -> Auth -> flash($this -> Flash);
            }
        }

        $this -> executeView();
    }

}
