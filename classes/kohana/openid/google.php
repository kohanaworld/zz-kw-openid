<?php defined('SYSPATH') OR die('No direct access allowed.');

abstract class Kohana_OpenID_Google extends OpenID {

	// Google does not require the username to be passed in the openID string.
	protected $_identity = 'https://www.google.com/accounts/o8/id';
}