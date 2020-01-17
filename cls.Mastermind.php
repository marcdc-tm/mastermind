<?php

require_once 'cls.Code.php';
require_once 'cls.SpeelRij.php';
require_once 'cls.SpelStatus.php';

class Mastermind {
	private $code;
	private $status;
	private $aantalRijen = 8;
	private $rij = array();
	private $positie = 0;
	
	public function __construct() {
		$this->start();
	}
	
	public function start() {
		$this->code = new Code();
		$this->rij = array();
		for ($i=0; $i<$this->aantalRijen; $i++) {
			$this->rij[] = new SpeelRij($this->code);
		}
		$this->status = SpelStatus::getSpelStatus(SpelStatus::BEZIG);
		$this->positie = 0;
	}
	
	public function getStatus() {
		return $this->status;
	}
	
	public function getPositie() {
		return $this->positie;
	}
	
	public function getRij($positie) {
		return $this->rij[$positie];
	} 
	
	public function setAantalRijen($aantal) {
		if ($aantal>0 && $aantal<30) $this->aantalRijen = $aantal;
	}
	
	public function getAantalRijen() {
		return $this->aantalRijen;
	}
	
	public function getCode() {
		return $this->code;
	}
	
	public function zetRij(Array $kleuren) {
		$plaats1 = SpeelKleur::getInstance(constant("SpeelKleur::".$kleuren[0]));
		$plaats2 = SpeelKleur::getInstance(constant("SpeelKleur::".$kleuren[1]));
		$plaats3 = SpeelKleur::getInstance(constant("SpeelKleur::".$kleuren[2]));
		$plaats4 = SpeelKleur::getInstance(constant("SpeelKleur::".$kleuren[3]));
		$this->rij[$this->positie]->zetRij($plaats1, $plaats2, $plaats3, $plaats4);
		if ($this->rij[$this->positie]->getResultaat()->aantalZwart()==4) {
			$this->status = SpelStatus::getSpelStatus(SpelStatus::GEWONNEN);		
		} else {
			if ($this->positie==$this->aantalRijen) $this->status = SpelStatus::getSpelStatus(SpelStatus::VERLOREN);
		}
		$this->positie++;
	}
	
	public function setVerloren() {
		$this->status = SpelStatus::getSpelStatus(SpelStatus::VERLOREN);
	}
}