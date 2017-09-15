<?php

class Globalstats extends BaseModel{

	public function __construct($attributes){
		parent::__construct($attributes);
	}
	
	public static function increase_carbon($amount){
		$query = DB::connection()->prepare('UPDATE Globalstats SET value = value + :tons WHERE id = 1');
		$query->execute(array('tons' => round($amount / 5)));
	}

	public static function get_carbon(){
		$query = DB::connection()->prepare('SELECT value FROM Globalstats WHERE id = 1 LIMIT 1');
		$query->execute();
		$row = $query->fetch();
		return $row['value'];
	}
}