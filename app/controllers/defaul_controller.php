<?php

class DefaultController extends BaseController{

	public static function index(){
		View::make('index.html', array('account_logged_in' => self::get_account_logged_in()));
	}

	public static function kirves(){
		View::make('kirves.html');
	}

	public static function sandbox(){
		$review = new Review(array(
			'header' => '',
			'lead' => '',
			'content' => '',
			'score' => 'ayy',
			'user_id' => 'lol'
			));
		$errors = $review->errors();
		Kint::dump($errors);
	}
}