<?php

class AccountController extends BaseController
{

    public static function list() {
        $accounts = Account::all();
        View::make('test.html', array('accounts' => $accounts, 'account_logged_in' => self::get_account_logged_in()));
    }

    public static function handle_login() {
        $params = $_POST;
        $account = Account::authenticate($params['email'], $params['password']);
        if (!$account) {
            View::make('account/login.html', array('error' => 'Wrong username or password', 'email' => $params['email']));
        } else {
			$_SESSION['account'] = $account->id;
			self::redirect();
            Redirect::to('/user/profile');
        }
    }

    public static function login() {
        View::make('account/login.html');
	}

	public static function signup(){
		View::make('account/signup.html');
	}

	/* vaiheessa */
    public static function store() {
        $params = $_POST;
        $errors = [];
        if ($params['password'] != $params['password2']) {
            $errors[] = "Passwords do not match";
        }
        $attributes = array(
            'email' => $params['email'],
            'password' => $params['password'],
            'admin' => false
            );
        $account = new Account($attributes);
        $errors = array_merge($errors, $account->errors());
        if (count($errors) == 0) {
            $account->save();
            $account = Account::authenticate($account->name, $account->password);
            $_SESSION['account'] = $account->id;
            Redirect::to('/', array('message' => 'Your account has been created!', 'account_logged_in' => $account));
        } else {
            View::make('account/account_add.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }
}
