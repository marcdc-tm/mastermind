<?php

require_once 'cls.Code.php';
require_once 'cls.SpeelKleur.php';
require_once 'cls.ResultaatRij.php';

class SpeelRij {
	private $rij;
	private $resultaat;
	private $code;
	
	public function __construct(Code $code) {
		$this->rij = array(null, null, null, null);
		$this->code = $code;
		$this->resultaat = null;
	}
	
	public function leegRij() {
		foreach ($this->rij as $key=>$value) $this->rij[$key] = null;
		$this->resultaat = null;
	}
	
	public function zetRij(SpeelKleur $plaats1, SpeelKleur $plaats2, SpeelKleur $plaats3, SpeelKleur $plaats4) {
		$this->rij[0] = $plaats1;
		$this->rij[1] = $plaats2;
		$this->rij[2] = $plaats3;
		$this->rij[3] = $plaats4;
		$this->berekenResultaat();
	}
	
	public function getKleur($plaats) {
		if (!is_int($plaats) || $plaats<0 || $plaats>(count($this->rij) - 1)) throw new OnbestaandePlaatsException("Er zijn slechts 4 kleuren op een rij!");
		return $this->rij[$plaats];
	}
	
	private function berekenResultaat() {
		$this->resultaat = new ResultaatRij();
		$inRijGehad = array(false, false, false, false);
		$inCodeGehad = array(false, false, false, false);
		try {
			// bereken de zwarte: juiste kleur op juiste plaats
			for ($i=0; $i<count($this->rij); $i++) {
				if ($this->rij[$i]==$this->code->getKleur($i)) {
					$inRijGehad[$i] = true;
					$inCodeGehad[$i] = true;
					$this->resultaat->add(ResultaatKleur::getResultaatKleur(ResultaatKleur::zwart));
				}
			}
			// bereken de witte: juiste kleur op foutieve plaats
			for ($i=0; $i<count($this->rij); $i++) {
				if (!$inRijGehad[$i]) {
					for ($j=0; $j<count($this->rij); $j++) {
						if (!$inCodeGehad[$j]) {
							if ($this->rij[$i]==$this->code->getKleur($j)) {
								$inCodeGehad[$j] = true;
								$this->resultaat->add(ResultaatKleur::getResultaatKleur(ResultaatKleur::wit));
								break;
							}
						}
					}
				}
			}
		} catch (OnbestaandePlaatsException $e) {
			echo $e;
		}
	}
	
	public function getResultaat() {
		return $this->resultaat;
	}
	
	public function __toString() {
		$str = "";
		foreach ($this->rij as $kleur) $str .= $kleur . ", ";
		$str = substr($str, 0, -2) . " (" . $this->resultaat . ")";
		return $str;
	}
}