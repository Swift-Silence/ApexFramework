<?php

// The networking main handler.

namespace ApexDevelopment\Networking;

class Networking
{

	// The request.
	public static $uri = null;

	private static $sessionStarted = null;

	// Initializes the networking variables.
	public static function init()
	{
		static::$uri = ltrim(parse_url(static::getURL(), PHP_URL_PATH), '/');
		static::$sessionStarted = false;
	}

	public static function redirect($url)
	{
		header("Location: $url");
	}

	/**
	 * https://stackoverflow.com/questions/13646690/how-to-get-real-ip-from-visitor @Teneff
	 * @return string The IP Address
	 */
	public static function getRealIP()
	{
		if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') > 0)
			{
	            $addr = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
	            return trim($addr[0]);
	        }
			else
			{
	            return $_SERVER['HTTP_X_FORWARDED_FOR'];
	        }
	    }
	    else
		{
	        return $_SERVER['REMOTE_ADDR'];
	    }
	}

	public static function cookie($name, $val = null, $ttl = null)
	{
		$name = strtolower($name);

		if ($val != null && $ttl != null)
		{
			$val = base64_encode($val);
			setcookie($name, $val, time() + $ttl, '/');
			return true;
		}
		else
		{
			if (isset($_COOKIE[$name]) && !empty($_COOKIE[$name]))
			{
				$val = base64_decode($_COOKIE[$name]);
				return $val;
			}
			else
			{
				return false;
			}
		}
	}

	public static function session($name, $val = null)
	{
		if (static::$sessionStarted == false)
		{
			static::$sessionStarted = true;
			session_start();
		}

		$name = strtolower($name);

		if ($val != null)
		{
			$val = base64_encode($val);
			$_SESSION[$name] = $val;
			return true;
		}
		else
		{
			if (isset($_SESSION[$name]) && !empty($_SESSION[$name]))
			{
				$val = base64_decode($_SESSION[$name]);
				return $val;
			}
			else
			{
				return false;
			}
		}
	}

	public function killActiveSessions()
	{
		session_destroy();
	}

	public function killSession($name)
	{
		if (isset($_SESSION[$name]))
		{
			unset($_SESSION[$name]);
		}
	}

	public function killCookie($name)
	{
		setcookie($name, null, time() - 3600, '/');
	}

	private function getURL()
	{
		$protocol = 'http';
		if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
		{
			$protocol = 'https';
		}

		return $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}

}
