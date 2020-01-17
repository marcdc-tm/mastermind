<?php

require_once("cls.Mastermind.php");

class MastermindGUI {
	const TITEL = "Mastermind";
	private $model;

	public function __construct() {
		if (isset($_POST["model"]) && !isset($_POST["speel"])) {
			$this->model = unserialize(base64_decode($_POST["model"]));
			if (isset($_POST["zet"])) {
				$this->model->zetRij($_POST["kleur"]);
			} 
			if (isset($_POST["toon"])) $this->model->setVerloren();
		} else {
			$this->model = new Mastermind();
		}
		$this->toonHeader();
		$this->toonRijen();
		$this->toonCode();
		$this->toonFooter();
	}

	private function toonHeader() {
		echo "<!DOCTYPE html>\n";
		echo "<html lang=\"nl\">\n";
		echo "<head>\n";
		echo "<meta charset=\"UTF-8\">\n";
		echo "<link rel=\"stylesheet\" href=\"http://html5resetcss.googlecode.com/files/html5reset-1.6.1.css\">\n";
		echo "<title>".self::TITEL."</title>\n";
		echo "<link rel=\"stylesheet\" href=\"css/mastermind.css\" type=\"text/css\">\n";
		echo "</head>\n";		
		echo "<body>\n";
		echo "<div id=\"container\">\n";
		echo "<header>\n";
		echo "<img src=\"images/mastermind.jpeg\">\n";
		echo "<h1>MASTERMIND</h1>\n";
		echo "<p>Easy to learn, easy to play, not so easy to win</p>\n";
		echo "<p id=\"status\">Het spel is ".$this->model->getStatus()."</p>\n";
		echo "</header>\n";
		echo "<form action=\"\" method=\"post\">\n";
		echo "<input type=\"hidden\" name=\"model\" value=\"".base64_encode(serialize($this->model))."\" />\n";
	}
	
	private function toonFooter() {
		echo "</form>\n";
		echo "</div>\n";
		echo "</body>\n";
		echo "</html>\n";
	}
	
	private function toonCode() {
		echo "<footer>\n";
		if ($this->model->getStatus()->getSleutel()!=SpelStatus::BEZIG) {
			$id = "";
			for ($i=0; $i<4; $i++) {
				$id = "id=\"".$this->model->getCode()->getKleur($i)."\"";
				echo "<div class=\"circle\" $id></div>\n";
			}
			echo "<div id=\"knop\"><input type=\"submit\" value=\"Speel opnieuw\" name=\"speel\"></div>\n";
		} else {
			for ($i=0; $i<4; $i++) {
				echo "<div class=\"circle\"><span>?</span></div>\n";
			}
			echo "<div id=\"knop\"><input type=\"submit\" value=\"Toon code\" name=\"toon\"></div>\n";
		}
		echo "</footer>\n";
	}
	
	private function toonRijen() {
		echo "<section>\n";
		for ($rij=0; $rij<$this->model->getPositie(); $rij++) {
			$this->toonRij($rij);
		}
		if ($this->model->getStatus()->getSleutel()==SpelStatus::BEZIG) $this->toonRij($this->model->getPositie());
		echo "</section>\n";
	}
	
	private function toonRij($positie) {
		$zwart = 0;
		$wit = 0;
		if ($positie<$this->model->getPositie()) {
			$zwart = $this->model->getRij($positie)->getResultaat()->aantalZwart();
			$wit = $this->model->getRij($positie)->getResultaat()->aantalWit();
		}
		echo "<aside><div>\n";
		for ($i=0; $i<4; $i++) {
			$id = "";
			if ($i<$zwart+$wit) $id = "id=\"wit\"";
			if ($i<$zwart) $id = "id=\"zwart\"";
			echo "<div class=\"smallcircle\" $id></div>\n";
		}
		echo "</div></aside>\n";
		echo "<article>\n";
		if ($positie==$this->model->getPositie()) {
			for ($i=0; $i<4; $i++) {
				echo "<div class=\"playcircle\">\n";
				$onchange = "onchange=\"this.setAttribute('id', this.options[this.selectedIndex].value)\"";
				echo "<select name=\"kleur[]\" $onchange>\n";
				foreach (SpeelKleur::values() as $kleur) {
					$id = "id=\"".SpeelKleur::getInstance(constant("SpeelKleur::".$kleur))."\"";
					echo "<option $id value=\"$kleur\">$kleur</option>\n";
				}
				echo "</select>\n";
				echo "</div>\n";
			}
		} else {
			$id = "";
			for ($i=0; $i<4; $i++) {
				//echo "Positie ".$positie.", plaats ".$i." = ".$this->model->getRij($positie)->getKleur($i)."<br>";
				if ($positie<$this->model->getPositie()) $id = "id=\"".$this->model->getRij($positie)->getKleur($i)."\"";
				echo "<div class=\"circle\" $id></div>\n";
			}
		}
		if ($positie==$this->model->getPositie()) {
			echo "<div id=\"knop\"><input type=\"submit\" value=\"Zet kleuren\" name=\"zet\"></div>\n";
		}
		echo "</article>\n";
	}
}
