<?php

namespace Models;

/**
 * The sessions table model for standard sessions.
 */

class SessionsModel extends \ApexDevelopment\Core\Model\Base
{

    public function init()
    {
        $structure = [
            'id' => 'int(21)',
            'token' => 'varchar(64) PRIMARY KEY',
            'ip_address' => 'varchar(15)'
        ];

        $this -> create($structure);
    }

}
