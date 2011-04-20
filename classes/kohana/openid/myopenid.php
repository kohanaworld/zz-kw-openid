<?php defined('SYSPATH') OR die('No direct access allowed.');

abstract class Kohana_OpenID_MyOpenID extends OpenID {

	protected function _format_identity($value)
	{
		return $value.'.myopenid.com';
	}
}