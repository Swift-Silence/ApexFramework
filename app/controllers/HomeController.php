<?php

namespace Controllers;

use ApexDevelopment\Core\Controller;

class HomeController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $this -> Auth -> deny('authorized');
        $this -> Auth -> filter();
    }

    public function index()
    {
        $this -> executeView();
    }

}
