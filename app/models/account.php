<?php

class Account extends BaseModel{

	public $id, $email, $password, $first_name, $last_name, $phone_number;

	public function __construct($attributes) {
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
		$query = DB::connection()->prepare('SELECT * FROM Account WHERE email = :email LIMIT 1');
		$query->execute(array('email' => $email));
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
			if ($account->checkPassword($password, $account)) {
			return $account;
			}
		}
		return null;
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

	public static function increase_offset_amount($id, $amount){
		$query = DB::connection()->prepare('UPDATE Account SET total_co2_tons_saved = total_co2_tons_saved + :tons, total_money_donated = total_money_donated + :amount WHERE id = :id');
		$query->execute(array('tons' => ($amount / 5), 'amount' => $amount, 'id' => $id));
	}

	public function errors(){
		$errors = array(
			/* stuff for validating the values here
			*/
			'email' => $this->validateEmail($this->email),
			'first_name' => $this->validateName($this->first_name, "First name"),
			'last_name' => $this->validateName($this->last_name, "Last name")

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

	private function validateName($name, $variableName = "Name") {
		if (preg_match("/^\p{Lu}[\p{L} '&-]*[\p{L}]$/u", $name)) {
			return null;
		}
		return $variableName . " is not valid";
	}
	private function checkPassword($password, $account) {
		$hash = $account->password;
		// Verify stored hash against plain-text password
		if (password_verify($password, $hash)) {
    // Check if a newer hashing algorithm is available
    // or the cost has changed
    	if (password_needs_rehash($hash, PASSWORD_DEFAULT)) {
        // If so, create a new hash, and replace the old one
        $newHash = password_hash($password, PASSWORD_DEFAULT);
				$query = DB::connection()->prepare('UPDATE Account SET password = :password WHERE id = :id');
				$query->execute(array('password' => $newHash, 'id' => $account->id));

    	}

    // Log user in
			return true;
		}
		return false;
	}
}
