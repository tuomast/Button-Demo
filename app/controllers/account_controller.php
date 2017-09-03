<?php

class AccountController extends BaseController{

    public static function list(){
		$accounts = Account::all();
		View::make('test.html', array('accounts' => $accounts, 'account_logged_in' => self::get_account_logged_in()));
	}

}