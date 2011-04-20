<?php defined('SYSPATH') OR die('No direct access allowed.');

abstract class Kohana_OpenID_Yahoo extends OpenID {

	// Yahoo! does not require the username to be passed in the openID string.
	protected $_identity = 'me.yahoo.com';

	/*protected function _format_identity($value)
	{
		return 'me.yahoo.com/'.$value;
	} */
}