<?php

class DefaultController extends BaseController{

	public static function index(){
		View::make('index.html', array('account_logged_in' => self::get_account_logged_in()));
	}

	public static function offset(){
		parent::check_logged_in("/offset"); //saves the path for later use, redirects to login if not logged in
		View::make('offset/subscribe.html', array('account_logged_in' => self::get_account_logged_in()));
	}

	public static function offset_complete(){
		$params = $_POST;
		View::make('offset/complete.html', array('account_logged_in' => self::get_account_logged_in(), 'amount' => $params['amount']));
	}
}