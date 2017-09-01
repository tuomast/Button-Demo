<?php

class Account extends BaseModel{

	public $id, $name, $password, $admin;

	public function __construct($attributes){
		parent::__construct($attributes);
	}

	public static function all(){
		$query = DB::connection()->prepare('SELECT * FROM Account');
		$query->execute();
		$rows = $query->fetchAll();
		$arvostelut = array();

		foreach($rows as $row){
			$accounts[] = new Account(array(
				'id' => $row['id'],
				'name' => $row['name'],
				'password' => $row['password'],
				'admin' => $row['admin']
				));
		}
		return $accounts;
	}

	public static function find($id){
		$query = DB::connection()->prepare('SELECT * FROM Account WHERE id = :id LIMIT 1');
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if($row){
			$account = new Account(array(
				'id' => $row['id'],
				'name' => $row['name'],
				'password' => $row['password'],
				'admin' => $row['admin']
				));

			return $account;
		}
		return null;
	}


	public function save(){
		$query = DB::connection()->prepare('INSERT INTO Account (name, password, admin) VALUES (:name, :password, :admin) RETURNING id');

		$query->bindValue(':name', $this->name, PDO::PARAM_STR);
		$query->bindValue(':password', $this->password, PDO::PARAM_STR);
		$query->bindValue(':admin', $this->admin, PDO::PARAM_BOOL);

		$query->execute();

		$row = $query->fetch();
		$this->id = $row['id'];
	}

	public function modify(){
		$query = DB::connection()->prepare('UPDATE Account SET name = :name, password = :password, admin = :admin WHERE id = :id');

		$query->bindValue(':name', $this->name, PDO::PARAM_STR);
		$query->bindValue(':password', $this->password, PDO::PARAM_STR);
		$query->bindValue(':admin', $this->admin, PDO::PARAM_BOOL);
		$query->bindValue(':id', $this->id, PDO::PARAM_INT);

		$query->execute();
	}

	public function remove(){
		$query = DB::connection()->prepare('DELETE FROM Account WHERE id = :id');
		$query->execute(array('id' => $this->id));
	}

	public static function authenticate($name, $password){
		$query = DB::connection()->prepare('SELECT * FROM Account WHERE name = :name AND password = :password LIMIT 1');
		$query->execute(array('name' => $name, 'password' => $password));
		$row = $query->fetch();

		if($row){
			$account = new Account(array(
				'id' => $row['id'],
				'name' => $row['name'],
				'password' => $row['password'],
				'admin' => $row['admin']
				));
			return $account;
		}else{
			return null;
		}
	}

	public static function name_exists($string){
		$query = DB::connection()->prepare('SELECT * FROM Account WHERE UPPER(name) = UPPER(:string) LIMIT 1');
		$query->execute(array('string' => $string));
		$row = $query->fetch();

		if($row){
			return "Username already taken";
		}
		return null;
	}

	public function errors(){
		$errors = array(
			parent::validate_string_length("Username", $this->name, 5, 30),
			self::name_exists($this->name),

			parent::validate_string_length("Password", $this->password, 5, 50),

			parent::validate_boolean("Admin-field", $this->admin)
		);
		$errors = array_filter($errors);
		return $errors;
	}
}