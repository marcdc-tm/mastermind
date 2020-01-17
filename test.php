<?php

require_once 'cls.SpeelRij.php';

$code = new Code();
echo $code."<br>";

$rij = new SpeelRij($code);
$rij->zetRij(SpeelKleur::getKleur(SpeelKleur::ROOD), SpeelKleur::getKleur(SpeelKleur::ZWART), SpeelKleur::getKleur(SpeelKleur::WIT), SpeelKleur::getKleur(SpeelKleur::ROOD));
echo $rij;
echo "<br>";
echo $rij->getResultaat()->aantalWit()." WIT<br>";
echo $rij->getResultaat()->aantalZwart()." ZWART<br>";
