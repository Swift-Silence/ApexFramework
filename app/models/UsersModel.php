<?php

namespace Models;

class UsersModel extends \ApexDevelopment\Core\Model\Base
{

    public function init()
    {

        $structure = [
            'id' => 'int(21) PRIMARY KEY AUTO_INCREMENT',
            'username' => 'varchar(15)',
            'email' => 'varchar(255)',
            'password' => 'varchar(64)',
            'salt' => 'varchar(64)'
        ];

        $this -> create($structure);

    }

    public function beforeEmail($str)
    {
        return strtolower($str);
    }

}
