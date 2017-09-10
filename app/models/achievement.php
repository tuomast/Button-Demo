<?php

class achievement extends BaseModel{

  public $id, $name, $description, $logo_url;
  
  public function __construct($attributes){
		parent::__construct($attributes);
	}

}





 ?>
