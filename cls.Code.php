<?php

require_once 'cls.SpeelKleur.php';
require_once 'cls.OnbestaandePlaatsException.php';

class Code {
	private $rij;
	
	public function __construct() {
		$this->rij[0] = SpeelKleur::randomKleur();
		$this->rij[1] = SpeelKleur::randomKleur();
		$this->rij[2] = SpeelKleur::randomKleur();
		$this->rij[3] = SpeelKleur::randomKleur();
	}
	
	public function getKleur($plaats) {
		if (!is_int($plaats) || $plaats<0 || $plaats>(count($this->rij) - 1)) throw new OnbestaandePlaatsException("Er zijn slechts 4 kleuren op een rij!");
		return $this->rij[$plaats];
	}
	
	public function __toString() {
		$str = "";
		foreach ($this->rij as $kleur) $str .= $kleur . ", ";
		return substr($str, 0, -2);
	}
}