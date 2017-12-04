<?php

// Authentication plugin.
// Allows for a log in system where each user has personalized site settings and views.

namespace Plugins\Auth;

use ApexDevelopment\Core\Model;
use ApexDevelopment\Networking\Networking;
use ApexDevelopment\Plugins\PluginManager;

/**
 * Authentication Class
 *
 * Allows the ability to authenticate users and have them log into their own
 * accounts.
 */
class Auth extends \ApexDevelopment\Plugins\Plugin
{

    public $error = null;

    public $errors = [];

    public $userInfo = [];

    public $UserInfo = null;

    private $Model = null;

    /**
     * Holds the registration fields that were sent via post.
     * @var null|array
     */
    private $registrationFields = null;

    private $loginFields = null;

    private $loginRedirect = null;

    private $logoutRedirect = null;

    private $filter = [];

    private $userID = null;

    private $token = null;

    private $PluginManager = null;

    /**
     * Processes any params sent via $params
     * @param array $params Any parameters used.
     */
    public function __construct(array $params)
    {
        parent::__construct();

        if (isset($params['loginRedirect']))
        {
            $this -> loginRedirect = $params['loginRedirect'];
        }

        if (isset($params['logoutRedirect']))
        {
            $this -> logoutRedirect = $params['logoutRedirect'];
        }

        $this -> error = false;

        $this -> Model = new Model();

        $this -> usersModel = $this -> Model -> loadModel('users');
        $this -> Model -> init();

        $this -> Sessions = $this -> loadSubClass('Sessions');

        $this -> filter['deny'] = [];

        $this -> PluginManager = new PluginManager();
        $this -> UserInfo = $this -> PluginManager -> load('UserInfo');
    }

    /**
     * Sets the registrationFields for checking.
     * @param  array $fields The registration fields.
     * @return true|false Whether registration succeeds.
     */
    public function register($fields)
    {
        $this -> registrationFields = $fields;

        return $this -> checkRegistrationFields();
    }

    public function login($fields)
    {
        $this -> loginFields = $fields;

        return $this -> checkLoginFields();
    }

    public function flash($Flash)
    {
        foreach ($this -> errors as $msg)
        {
            $Flash -> setError($msg);
        }
    }

    public function loginRedirect()
    {
        Networking::redirect($this -> loginRedirect);
    }

    public function logoutRedirect()
    {
        Networking::killActiveSessions();
        Networking::killCookie('auth');
        $this -> Sessions -> wipe($this -> userID, $this -> token);
        Networking::redirect($this -> logoutRedirect);
    }

    public function deny($group)
    {
        $this -> filter['deny'][] = $group;
    }

    public function filter()
    {
        $filter = $this -> filter;
        $denied = $filter['deny'];

        if (in_array('public', $denied))
        {
            if (Networking::session('auth'))
            {
                if (!$this -> checkSession())
                {
                    if (!$this -> checkCookie())
                    {
                        $this -> logoutRedirect();
                    }
                }

                $this -> fetchUserInfo();
                $this -> UserInfo -> loadUserID($this -> userInfo['id']);
            }
            else if (Networking::cookie('auth'))
            {
                if (!$this -> checkCookie())
                {
                    $this -> logoutRedirect();
                }

                Networking::session('auth', $this -> token);
                $this -> fetchUserInfo();
            }
            else
            {
                $this -> logoutRedirect();
            }
        }

        if (in_array('authorized', $denied))
        {
            if (Networking::session('auth'))
            {
                $token = Networking::session('auth');
                if ($this -> Sessions -> checkExists($token))
                {
                    $this -> loginRedirect();
                }
            }
            else if (Networking::cookie('auth'))
            {
                $token = Networking::cookie('auth');
                if ($this -> Sessions -> checkExists($token))
                {
                    $this -> loginRedirect();
                }
            }
        }
    }

    private function fetchUserInfo()
    {
        $uid = $this -> Sessions -> getUIDByToken($this -> token);

        $this -> userInfo = $this -> usersModel -> get(['id' => '=' . $uid]) -> fetch_assoc();
    }

    private function checkSession()
    {
        $this -> token = Networking::session('auth');
        return $this -> Sessions -> checkExists($this -> token);
    }

    private function checkCookie()
    {
        $this -> token = Networking::cookie('auth');
        return $this -> Sessions -> checkExists($this -> token);
    }

    private function checkLoginFields()
    {
        $fields = $this -> loginFields;

        if (!isset($fields['login']))
        {
            return false;
        }

        $email = $fields['email'];
        $password = $fields['password'];

        $res = $this -> usersModel -> get(['email' => '=' . $email]);

        if ($res -> num_rows == 1)
        {
            $account = $res -> fetch_assoc();

            $salt = $account['salt'];
            $hashedPassword = $account['password'];

            $verifyPassword = $this -> hashPassword($password, $salt);

            if ($verifyPassword == $hashedPassword)
            {
                $this -> Sessions -> establish($account['id']);
                $this -> UserInfo -> loadUserID($account['id']);
                return true;
            }
            else
            {
                $this -> error = true;
                $this -> addError('Invalid login credentials (L002).');
                return false;
            }
        }
        else
        {
            $this -> error = true;
            $this -> addError('Invalid login credentials (L001).');
            return false;
        }
    }

    private function checkRegistrationFields()
    {
        $fields = $this -> registrationFields;

        if (!isset($fields['register']))
        {
            return false;
        }

        $email = $fields['email'];
        $username = $fields['username'];
        $password = $fields['password'];
        $confirmPassword = $fields['confirm_password'];

        if (empty($email))
        {
            $this -> error = true;
            $this -> addError('You cannot submit an empty E-mail Address.');
        }

        if (empty($username))
        {
            $this -> error = true;
            $this -> addError('You cannot submit an empty username.');
        }

        if (empty($password))
        {
            $this -> error = true;
            $this -> addError('You cannot submit an empty password.');
        }

        if (empty($confirmPassword))
        {
            $this -> error = true;
            $this -> addError('You did not confirm your password.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $this -> error = true;
            $this -> addError('Invalid e-mail address "' . $email . '".');
        }

        $res = $this -> usersModel -> get(['email' => '=' . $email]);

        if ($res -> num_rows > 0)
        {
            $this -> error = true;
            $this -> addError('This account already exists. Please use a different e-mail address.');
            return false;
        }

        if (!preg_match('/^[A-Za-z0-9_-]{5,15}$/', $username))
        {
            $this -> error = true;
            $this -> addError('Invalid username. Must be alphanumeric (letters and numbers) and can only contain underscores or dashes. Minimum length of 5 characters, maximum length of 15.');
        }

        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $numbers   = preg_match('@[0-9]@', $password);

        if (!$uppercase || !$lowercase || !$numbers || strlen($password) < 8)
        {
            $this -> error = true;
            $this -> addError('Invalid password. Passwords must contain at least one uppercase letter, one lowercase letter, one number, and be at least 8 characters long.');
        }

        if ($password != $confirmPassword)
        {
            $this -> error = true;
            $this -> addError('Passwords do not match.');
        }

        if ($this -> error)
        {
            return false;
        }
        else
        {
            if ($this -> storeUser($email, $username, $password, $this -> generateSalt()))
            {
                return true;
            }
            else
            {
                $this -> error = true;
                $this -> addError('Unable to store your user account. Try again later.');
                return false;
            }
        }
    }

    private function generateSalt()
    {
        $str = "!@#$%^&*()-_=+[{}]:;<>,.?/~";

        for ($i = 0; $i < 10; $i++)
        {
            $str .= $str;
        }

        $str = str_shuffle($str);

        return substr($str, 0, 64);
    }

    private function storeUser($email, $username, $password, $salt)
    {
        $structure = [
            'email' => $email,
            'username' => $username,
            'password' => $this -> hashPassword($password, $salt),
            'salt' => $salt
        ];

        if ($this -> usersModel -> insert($structure))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function addError($msg)
    {
        $this -> errors[] = $msg;
    }

    private function hashPassword($password, $salt)
    {
        $str = $salt . $password . strrev($salt);
        return hash('sha256', $str);
    }

}
