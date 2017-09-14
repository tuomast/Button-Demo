<?php

class DefaultController extends BaseController{

	public static function index(){
		View::make('index.html', array('account_logged_in' => self::get_account_logged_in()));
	}

	public static function offset(){
		View::make('offset/subscribe.html', array('account_logged_in' => self::get_account_logged_in()));
	}

	public static function offset_complete(){
		$params = $_POST;
		if (parent::check_logged_in("/offset/complete") == false) { //saves the path for later use
			$_SESSION['offset'] = true;
			$_SESSION['offset_amount'] = $params['amount'];
			Redirect::to('/signup');
		}
		DefaultController
		Redirect::to('/user/profile');
	}
}