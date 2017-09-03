<?php

class Account extends BaseModel{

	public $id, $username, $email, $password, $firstname, $lastname;

	public function __construct($attributes){
		parent::__construct($attributes);
	}

	public static function all(){
		$query = DB::connection()->prepare('SELECT * FROM account');
		$query->execute();
		$rows = $query->fetchAll();
		$accounts = array();
		foreach($rows as $row){
			$accounts[] = new Account(array(
				'id' => $row['id'],
				'username' => $row['username'],
				'password' => $row['password'],
				'email' => $row['email'],
				'firstname' => $row['firstname'],
				'lastname' => $row['lastname']
				));
		}
		return $accounts;
	}

}