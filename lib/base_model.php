<?php

class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
  protected $validators, $validatees;

  public function __construct($attributes = null){
      // Käydään assosiaatiolistan avaimet läpi
    foreach($attributes as $attribute => $value){
        // Jos avaimen niminen attribuutti on olemassa...
      if(property_exists($this, $attribute)){
          // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
        $this->{$attribute} = $value;
      }
    }
  }

  public function get_time(){
    return date("Y:m:d:H:i:s");
  }

  public static function validate_string_length($name, $string, $smallest, $largest){
    if(strlen($string) < $smallest){
      return "${name} must be longer than $smallest characters";
    } elseif(strlen($string) > $largest){
      return "${name} must not be longer than $largest characters";
    }
    return null;
  }

  public static function validate_string_empty($name, $string){
    if($string == '' || $string == null){
      return "${name} must not be empty";
    }
    return null;
  }

  public static function validate_boolean($name, $string){
    if(is_bool($string) == false){
      return "${name} must be boolean";
    }
    return null;
  }

  public static function validate_int($name, $string){
    if($string == '' || $string == null){
      return "${name} cannot be empty";
    } elseif(strval($string) != strval(intval($string))) {
      return "${name} must be an integer";
    }
    return null;
  }

  public static function validate_int_range($name, $int, $smallest, $largest){
    if(self::validate_int($name, $int) == null){
      if($int > $largest){
        return "${name} must not be larger than ${largest}";
      } elseif($int < $smallest){
        return "${name} must not be smaller than ${smallest}";
      }
    }
    return null;
  }
}
