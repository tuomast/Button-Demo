<?php

class AccountController extends BaseController{

    public static function list(){
		$accounts = Account::all();
		View::make('test.html', array('accounts' => $accounts, 'account_logged_in' => self::get_account_logged_in()));
	}

	public static function handle_login(){
		$params = $_POST;
		$account = Account::authenticate($params['email'], $params['password']);
		if(!$account){
			View::make('account/account_login.html', array('error' => 'Wrong username or password', 'name' => $params['name']));
		}else{
			$_SESSION['account'] = $account->id;
			Redirect::to('/', array('message' => 'Welcome back ' . $account->name . '!', 'account_logged_in' => parent::get_account_logged_in()));
		}
	}

}