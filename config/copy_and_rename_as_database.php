<?php
  class DatabaseConfig{
    //copy this file and rename it as "database.php" to prevent github from overwriting it
    private static $use_database = 'psql';
    private static $connection_config = array(
      'psql' => array(
        'resource' => 'pgsql:',
        'username' => 'postgres',
        'password' => 'postgres'
      )
    );

    public static function connection_config(){
      $config = array(
        'db' => self::$use_database,
        'config' => self::$connection_config[self::$use_database]
      );
      return $config;
    }

  }
