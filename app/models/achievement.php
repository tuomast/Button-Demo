<?php

class achievement extends BaseModel{

  public $id, $name, $description, $logo_url, $levels, $current_level;

  public function __construct($attributes){
		parent::__construct($attributes);
	}

  public static function all(){
		$query = DB::connection()->prepare('SELECT * FROM Achievement');
		$query->execute();
		$rows = $query->fetchAll();
		$achievements = array();
		foreach($rows as $row){
			$achievement[] = new Achievement(array(
				'id' => $row['id'],
				'name' => $row['name'],
				'description' => $row['description'],
				'logo_url' => $row['logo_url'],
				'levels' => $row['levels']
				));
		}
		return $achievements;
	}

  public static function find($id){
		$query = DB::connection()->prepare('SELECT * FROM Achievement WHERE id = :id LIMIT 1');
		$query->execute(array('id' => $id));
		$row = $query->fetch();
		if($row){
			$achievement = new Achievement(array(
				'id' => $row['id'],
				'name' => $row['name'],
				'description' => $row['description'],
				'logo_url' => $row['logo_url'],
				'levels' => $row['levels']
				));
			return $achievement;
		}else{
			rfeturn null;
		}
	}
//EI TESTATTU
  public static function findByUser($id) {
    $query = DB:connection()->prepare('
      SELECT Achievement.id, Achievement.name, Achievement.description, Achievement.logo_url, Achievement.levels, Achievementaccount.current_level
      FROM Achievemen
      INNER JOIN Achievementaccount ON Achievement.id = Achievementaccount.achievement_id
      WHERE Achievementaccount.account_id = :id');
    $query->execute(array('id' => $id));
    $rows = $query->fetchAll();
    $achievements = array();
    foreach($rows as $row) {
      $achievements[] = new Achievement(array(
        'id' => $row['id'],
        'name' => $row['name'],
        'description' => $row['description'],
        'logo_url' => $row['logo_url'],
        'levels' => $row['levels'],
        'current_level' => $row['current_level']
      ));
    }
    return $achievements[];

  }


  public static function addAchievement($name, $description, $logo_url, $levels) {
    $query = DB:connection()->prepare('INSERT INTO Achievement VALUES(:name, :description, :logo_url, :levels)');
    $query->execute(array('name') => $name, 'description' => $description, 'logo_url' => $logo_url, 'levels' => $levels);
  }

  public static function addLevel() {
    $this->current_level++;
  }

}





 ?>
