<?php defined('SYSPATH') OR die('No direct access allowed.');

abstract class Kohana_OpenID {

	/**
	 * @static
	 * @param null $provider
	 * @return OpenID
	 */
	public static function factory($provider = NULL)
	{
		$class = 'openid' . ($provider ? '_'.$provider : '');
		return new $class;
	}

	/**
	 * @var LightOpenID
	 */
	protected $_openid;
	/**
	 * @var Default identity (optional)
	 */
	protected $_identity;
	protected $_identity_key = 'openid_id';

	protected function _format_identity($identity)
	{
		return $identity;
	}

	public function __construct()
	{
		$path = Kohana::find_file('vendor', 'openid');
		if ( ! $path)
		{
			throw new Kohana_Exception('OpenID library not found!');
		}
		require_once $path;
		$this->_openid = new LightOpenID();
		if ($this->_identity)
		{
			$this->_openid->identity = $this->_identity;
		}
	}

	public function identity($value = NULL)
	{
		if ($value === NULL)
		{
			return $this->_openid->identity;
		}

		$this->_openid->identity = $this->_format_identity($value);
		return $this;
	}

	public function public_id()
	{
		return Cookie::get($this->_identity_key);
	}

	public function realm($value = NULL)
	{
		if ($value === NULL)
		{
			return $this->_openid->realm;
		}

		$this->_openid->realm = $value;
		return $this;
	}

	public function mode()
	{
		return arr::get($this->_openid->data, 'openid_mode');
	}

	public function attributes()
	{
		return $this->_openid->getAttributes();
	}

	public function required($data = NULL)
	{
		if ($data == NULL)
		{
			return $this->_openid->required;
		}

		$this->_openid->required = (array)$data;
	}

	public function optional($data = NULL)
	{
		if ($data == NULL)
		{
			return $this->_openid->optional;
		}

		$this->_openid->optional = (array)$data;
	}

	public function returnUrl($value = NULL)
	{
		if ($value === NULL)
		{
			return $this->_openid->returnUrl;
		}

		$this->_openid->returnUrl = $value;
		return $this;
	}

	public function login($identity = NULL)
	{
		Cookie::set($this->_identity_key, $identity);

		if ($identity)
		{
			$this->identity($identity);
		}

		$identity = $this->identity();

		if (empty($identity))
		{
			throw new Kohana_Exception('OpenID identifier required');
		}

		if (empty($this->_openid->required))
		{
			$this->_openid->required = array('namePerson/friendly', 'contact/email');
		}

		if (empty($this->_openid->optional))
		{
			$this->_openid->optional = array('namePerson', 'namePerson/first');
		}

		Request::current()->redirect($this->_openid->authUrl());
	}

	public function complete_login()
	{
		if ($this->mode() == 'cancel')
		{
			return FALSE;
		}

		if ( ! $this->_openid->validate() )
		{
			return FALSE;
		}

		return $this->_openid->identity;
	}


}