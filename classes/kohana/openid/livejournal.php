<?php defined('SYSPATH') OR die('No direct access allowed.');

abstract class Kohana_OpenID_Livejournal extends OpenID {

	protected function _format_identity($value)
	{
		return $value.'.livejournal.com';
	}

}