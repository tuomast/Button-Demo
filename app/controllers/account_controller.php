<?php

class AccountController extends BaseController{


	public static function list(){
		parent::check_admin_rights();
		$accounts = Account::all();
		View::make('account/account_list.html', array('accounts' => $accounts, 'account_logged_in' => self::get_account_logged_in()));
	}

	public static function login(){
		parent::check_not_logged_in("You are already logged in");
		View::make('account/account_login.html', array('account_logged_in' => self::get_account_logged_in()));
	}

	public static function handle_login(){
		$params = $_POST;
		$account = Account::authenticate($params['name'], $params['password']);

		if(!$account){
			View::make('account/account_login.html', array('error' => 'Wrong username or password', 'name' => $params['name']));
		}else{
			$_SESSION['account'] = $account->id;
			Redirect::to('/', array('message' => 'Welcome back ' . $account->name . '!', 'account_logged_in' => parent::get_account_logged_in()));
		}
	}

	public static function logout(){
		$_SESSION['account'] = null;
		Redirect::to('/login', array('message' => 'You have logged out'));
	}

	public static function add(){
		parent::check_not_logged_in("You seem to already have an account");
		View::make('account/account_add.html');
	}

	public static function store(){
		$params = $_POST;
		$errors = [];
		if($params['password'] != $params['password2']) {
			$errors[] = "Passwords do not match!";
		}
		$attributes = array(
			'name' => $params['name'],
			'password' => $params['password'],
			'admin' => false
			);
		$account = new Account($attributes);
		$errors = array_merge($errors, $account->errors());
		if(count($errors) == 0){
			$account->save();
			$account = Account::authenticate($account->name, $account->password);
			$_SESSION['account'] = $account->id;
			Redirect::to('/', array('message' => 'Your account has been created!', 'account_logged_in' => $account));
		}else{
			View::make('account/account_add.html', array('errors' => $errors, 'attributes' => $attributes));
		}
		
	}

	public static function edit($id){
		parent::check_admin_rights();
		$account = Account::find($id);
		View::make('account/account_modify.html', array('attributes' => $account, 'account_logged_in' => parent::get_account_logged_in()));
	}

	public static function modify($id){
		parent::check_admin_rights();
		$params = $_POST;
		$errors = [];
		if($params['password'] != $params['password2']) {
			$errors[] = "Passwords do not match!";
		}
		$account = Account::find($id);
		$attributes = array(
			'id' => $id,
			'name' => $params['name'],
			'password' => $params['password'],
			'admin' => $account->admin
			);
		$account = new Account($attributes);
		$errors = array_merge($errors, $account->errors());

		if(count($errors) > 0){
			View::make('account/account_modify.html', array('errors' => $errors, 'attributes' => $attributes, 'account_logged_in' => parent::get_account_logged_in()));
		}else{
			$account->modify();
			Redirect::to('/list/users', array('message' => 'Account succesfully edited', 'account_logged_in' => parent::get_account_logged_in()));
		}
	}

	public static function remove($id){
		parent::check_admin_rights();
		$account = Account::find($id);
		$reviews = Review::reviews_for_user($id);
		foreach ($reviews as $review) {
			$review->remove();
		}
		$account->remove();
		Redirect::to('/list/users', array('message' => 'Account deleted!', 'account_logged_in' => parent::get_account_logged_in()));
	}
}