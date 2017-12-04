<?php

// Test model

namespace Models;

class TestModel extends \ApexDevelopment\Core\Model\Base
{

    public function init()
    {
        $structure = [
            'id' => 'int(21) PRIMARY KEY AUTO_INCREMENT',
            'name' => 'varchar(30)'
        ];

        $this -> create($structure);
    }

}
