<?php defined('SYSPATH') OR die('No direct access allowed.');

abstract class Kohana_OpenID_Wordpress extends OpenID {

	protected function _format_identity($identity)
	{
		return $identity.'.wordpress.com';
	}

}