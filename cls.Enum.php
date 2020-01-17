<?php

abstract class Enum {
	private static $subclasses = array();
	private static $values = array();
	private static $first = array();
	protected $naam;
	protected $sleutel;
	
	private function __construct($sleutel=0) {
		$class = get_class($this);
		$this->sleutel = $sleutel;
		$this->naam = "";
		if (isset(self::$values[$class][$sleutel])) $this->naam = self::$values[$class][$sleutel];
	}
	
	public static function values() {
		$class = get_called_class();
		if (!isset(self::$subclasses[$class])) self::loadValues();
		return self::$values[$class];
	}
	
	public static function value($name) {
		$class = get_called_class();
		if (!isset(self::$subclasses[$class])) self::loadValues();
		return array_search($name, self::$values[$class]);
	}
	
	public static function getInstance($sleutel=0) {
		$class = get_called_class();
		if (!isset(self::$subclasses[$class])) self::loadValues();
		if (!array_key_exists($sleutel, self::$values[$class])) $sleutel = self::$first[$class];
		if (!isset(self::$subclasses[$class][$sleutel])) self::$subclasses[$class][$sleutel] = new $class($sleutel);
		return self::$subclasses[$class][$sleutel];
	}
	
	public static function __callStatic($name, $pars) {
		$class = get_called_class();
		if ($name=="get".$class) return $class::getInstance($pars[0]);
		return false;
	}
	
	private static function loadValues() {
		$class = get_called_class();
		if (!isset(self::$subclasses[$class])) {
			self::$subclasses[$class] = array();
			$realclass =  new ReflectionClass($class);
			$constants = $realclass->getConstants();
			$constants = array_flip($constants);
			$keys = array_keys($constants);
			self::$first[$class] = $keys[0];
			self::$values[$class] = $constants;
		}
	}
	
	public function __toString() {
		return $this->naam;
	}
	
	public function getSleutel() {
		return $this->sleutel;
	}
}
