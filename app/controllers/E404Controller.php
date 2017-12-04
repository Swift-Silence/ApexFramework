<?php

// The 404 Controller

namespace Controllers;

use ApexDevelopment\Core\Controller;

class E404Controller extends Controller
{

    public function index()
    {
        try {
            $this -> Model -> loadModel('test');

            $this -> Model -> init();
        }
        catch (\Exception $e)
        {
            echo $e -> getMessage();
        }

        $this -> executeView();
    }

    public function test()
    {
        echo 'test';
    }

}
