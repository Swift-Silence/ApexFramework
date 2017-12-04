<?php

namespace Plugins\UserInfo;

use ApexDevelopment\Core\Model;

/**
 * Handles user information for the Auth plugin.
 */
class UserInfo extends \ApexDevelopment\Plugins\Plugin
{

    private $loaded = null;
    private $uid = null;
    private $userInfo = [];
    private $defaultStructure = [
        'permissions' => 'u',
        'current_paycheck' => -1,
        'budget_scheme' => -1,
        'account_setup' => 'n',
        'current_cycle' => -1,
        'change_saved' => -1,
        'points' => 0,
        'points_threshold' => 500,
        'reward_cycle' => 'n'
    ];

    private $Model = null;

    public function __construct(array $params)
    {
        parent::__construct();

        $this -> loaded = false;

        $this -> Model = new Model();

        $this -> userInfoModel = $this -> Model -> loadModel('userinfo');
        $this -> Model -> init();
    }

    public function loadUserID($uid)
    {
        $this -> uid = $uid;
        $this -> loadUserInfo();
        $this -> loaded = true;
        return true;
    }

    public function get($info)
    {
        if (isset($this -> userInfo[$info]))
        {
            return $this -> userInfo[$info];
        }

        return false;
    }

    public function set($info, $val)
    {
        if ($this -> userInfoModel -> update([$info => $val]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function loadUserInfo()
    {
        if ($res = $this -> userInfoModel -> get(['id' => '=' . $this -> uid]))
        {
            if ($res -> num_rows == 0)
            {
                $this -> defaultStructure['id'] = $this -> uid;
                $this -> userInfoModel -> insert($this -> defaultStructure);
                $this -> loadUserInfo();
            }
            else
            {
                $this -> userInfo = $res -> fetch_assoc();
            }
        }
    }

}
