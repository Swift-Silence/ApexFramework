<?php

namespace Plugins\Auth;

/**
 * ApexDevelopment Authentication plugin Sessions handler.
 */

use ApexDevelopment\Core\Model;
use ApexDevelopment\Networking\Networking;

class Sessions
{

    private $Model = null;

    private $sessionsModel = null;

    public function __construct($params)
    {
        $this -> Model = new Model();

        $this -> sessionsModel = $this -> Model -> loadModel('Sessions');
        $this -> Model -> init();
    }

    public function establish($UID)
    {
        $token = $this -> generateToken();
        $IPAddress = Networking::getRealIP();

        $this -> sessionsModel -> insert([
            'id' => $UID,
            'token' => $token,
            'ip_address' => $IPAddress
        ]);

        Networking::session('auth', $token);
        Networking::cookie('auth', $token, 3600);

        return true;
    }

    public function generateToken()
    {
        $pool = str_repeat("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890", 10);
        $pool = str_shuffle($pool);
        return substr($pool, 0, 64);
    }

    public function checkExists($token)
    {
        $res = $this -> sessionsModel -> get(['token' => '=' . $token]);

        if ($res -> num_rows > 0)
        {
            $row = $res -> fetch_assoc();

            return $row['id'];
        }
        else
        {
            return false;
        }
    }

    public function wipe($uid, $token)
    {
        $this -> sessionsModel -> erase(['id' => '=' . $uid, '&token' => '=' . $token]);
    }

    public function getUIDByToken($token)
    {
        return $this -> sessionsModel -> get(['token' => '=' . $token]) -> fetch_assoc()['id'];
    }

}
