<?php

require_once 'cls.Enum.php';

class SpeelKleur extends Enum {
	const WIT = 0;
	const ZWART = 1;
	const ROOD = 2;
	const GROEN = 3;
	const BLAUW = 4;
	const GEEL = 5;
	const BRUIN = 6;
	
	public static function randomKleur()  {
		return parent::getInstance(mt_rand(0,6));
	}
}