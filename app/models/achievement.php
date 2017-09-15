<?php

class Achievement extends BaseModel
{

    public $id, $name, $description, $logo_url, $levels, $current_level, $time_achieved;

    public function __construct($attributes)
    {
        parent::__construct($attributes);
    }

    public static function all()
    {
        $query = DB::connection()->prepare('SELECT * FROM Achievement');
        $query->execute();
        $rows = $query->fetchAll();
        $achievements = array();
        foreach ($rows as $row) {
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

    public static function find($id)
    {
        $query = DB::connection()->prepare('SELECT * FROM Achievement WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if ($row) {
            $achievement = new Achievement(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'description' => $row['description'],
                'logo_url' => $row['logo_url'],
                'levels' => $row['levels']
                ));
            return $achievement;
        } else {
            return null;
        }
    }
        
    public static function achievementaccount_if_exists($user_id, $ach_id)
    {
        $query = DB::connection()->prepare('
				SELECT achievement_id, account_id FROM Achievementaccount
				WHERE account_id = :user_id AND achievement_id = :ach_id
				LIMIT 1
				');
        $query->execute(array('user_id' => $user_id, 'ach_id' => $ach_id));
        $row = $query->fetch();
        if ($row) {
            return true;
        }
        return false;
    }


    public static function find_for_user($id)
    {
        $query = DB::connection()->prepare('SELECT * FROM Achievement INNER JOIN Achievementaccount ON achievement_id = id WHERE account_id = :user_id ORDER BY timeachieved DESC');
        $query->execute(array('user_id' => $id));
        $rows = $query->fetchAll();
        $achievements = array();
        foreach ($rows as $row) {
            $achievements[] = new Achievement(array(
            'id' => $row['id'],
						'name' => $row['name'],
            'description' => $row['description'],
            'logo_url' => '{{base_path}}/assets/img/achievement.png',
            'levels' => $row['levels'],
            'current_level' => $row['current_level'],
            'time_achieved' => $row['timeachieved']
            ));
        }
        return $achievements;
    }


    public static function addAchievement($name, $description, $logo_url, $levels)
    {
        $query = DB::connection()->prepare('INSERT INTO Achievement VALUES(:name, :description, :logo_url, :levels)');
        $query->execute(array('name' => $name, 'description' => $description, 'logo_url' => $logo_url, 'levels' => $levels));
    }
    
    public static function add_achievement_to_user($user_id, $achievement_id)
    {
        if (self::achievementaccount_if_exists($user_id, $achievement_id) == false) {
            $query = DB::connection()->prepare('INSERT INTO Achievementaccount (account_id, achievement_id, timeachieved) VALUES (:user_id, :achievement_id, now())');
            $query->execute(array('user_id' => $user_id, 'achievement_id' => $achievement_id));
        }
    }

    public static function addLevel()
    {
        $this->current_level++;
    }
}
