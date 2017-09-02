<?php

class DefaultController extends BaseController{

	public static function index(){
		View::make('index.html', array('account_logged_in' => self::get_account_logged_in()));
	}

	public static function offset(){
		View::make('offset.html', array('account_logged_in' => self::get_account_logged_in()));
	}
}