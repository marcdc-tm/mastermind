<?php

class NoValidCardException extends Exception{
	public function __construct($errorMessage){
		parent::__construct($errorMessage);
	}	
}


?>
