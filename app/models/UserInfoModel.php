<?php

namespace Models;

/**
 * The model for the userinfo database.
 */
class UserInfoModel extends \ApexDevelopment\Core\Model\Base
{

    public function init()
    {
        $structure = [
            'id' => 'int(21) PRIMARY KEY',
            'permissions' => "enum('a','u')"
        ];

        $this -> create($structure);
    }

}
