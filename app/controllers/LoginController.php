<?php

namespace Controllers;

use ApexDevelopment\Core\Controller;

class LoginController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $this -> Auth -> deny('authorized');
        $this -> Auth -> filter();
    }

    public function index()
    {
        if ($this -> Request -> isPost())
        {
            if ($this -> Auth -> login($this -> Request -> post()))
            {
                $this -> Auth -> loginRedirect();
            }
            else
            {
                $this -> Auth -> flash($this -> Flash);
            }
        }

        $this -> executeView();
    }

}
