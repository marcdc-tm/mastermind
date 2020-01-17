<?php

require_once 'cls.ResultaatKleur.php';

class ResultaatRij {
	private $resultaat;
	
	public function __construct() {
		$this->resultaat = array();
	}
	
	public function add(ResultaatKleur $rk) {
		$this->resultaat[] = $rk;
	}
	
	public function aantalZwart() {
		$aantal = 0;
		foreach ($this->resultaat as $kleur) {
			if ($kleur==ResultaatKleur::getResultaatKleur(ResultaatKleur::zwart)) $aantal++;
		}
		return $aantal;
	}
	
	public function aantalWit() {
		$aantal = 0;
		foreach ($this->resultaat as $kleur) {
			if ($kleur==ResultaatKleur::getResultaatKleur(ResultaatKleur::wit)) $aantal++;
		}
		return $aantal;
	}
	
	public function __toString() {
		$str = "";
		foreach ($this->resultaat as $kleur) $str .= $kleur . ", ";
		if (strlen($str)>2) $str = substr($str, 0, -2);
		return $str;
	}
}