<?php

class Account extends BaseModel{

	public $id, $email, $password, $first_name, $last_name, $phone_number;

	public function __construct($attributes){
		parent::__construct($attributes);
	}

	public static function all(){
		$query = DB::connection()->prepare('SELECT * FROM Account');
		$query->execute();
		$rows = $query->fetchAll();
		$accounts = array();
		foreach($rows as $row){
			$accounts[] = new Account(array(
				'id' => $row['id'],
				'email' => $row['email'],
				'password' => $row['password'],
				'first_name' => $row['first_name'],
				'last_name' => $row['last_name'],
				'phone_number' => $row['phone_number']
				));
		}
		return $accounts;
	}

	public static function authenticate($email, $password){
		$query = DB::connection()->prepare('SELECT * FROM Account WHERE email = :email AND password = :password LIMIT 1');
		$query->execute(array('email' => $email, 'password' => $password));
		$row = $query->fetch();
		if($row){
			$account = new Account(array(
				'id' => $row['id'],
				'email' => $row['email'],
				'password' => $row['password'],
				'first_name' => $row['first_name'],
				'last_name' => $row['last_name'],
				'phone_number' => $row['phone_number']
				));
			return $account;
		}else{
			return null;
		}
	}

	public static function find($id){
		$query = DB::connection()->prepare('SELECT * FROM Account WHERE id = :id LIMIT 1');
		$query->execute(array('id' => $id));
		$row = $query->fetch();
		if($row){
			$account = new Account(array(
				'id' => $row['id'],
				'email' => $row['email'],
				'password' => $row['password'],
				'first_name' => $row['first_name'],
				'last_name' => $row['last_name'],
				'phone_number' => $row['phone_number']
				));
			return $account;
		}else{
			return null;
		}
	}

	public function save(){
		$query = DB::connection()->prepare('INSERT INTO Account (email, password, first_name, last_name, phone_number) VALUES (:email, :password, :first_name, :last_name, :phone_number) RETURNING id');
		$query->execute(array('email' => $this->email, 'password' => $this->password, 'first_name' => $this->first_name, 'last_name' => $this->last_name, 'phone_number' => $this->phone_number));
		$row = $query->fetch();
		$this->id = $row['id'];
	}

	public function errors(){
		$errors = array(
			/* stuff for validating the values here
			*/
			'email' => validateEmail($this->email),
			'name' => validateName($this->name)

		);
		$errors = array_filter($errors);
		return $errors;
	}

	private function validateEmail($email) {
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return null;
		}
		return "Email is not valid.";
	}

	private function validateName($name) {
		if (preg_match("/^\p{Lu}[\p{L} '&-]*[\p{L}]$/u", $name)) {
			return null;
		}
		return "Name is not valid";
	}
}
