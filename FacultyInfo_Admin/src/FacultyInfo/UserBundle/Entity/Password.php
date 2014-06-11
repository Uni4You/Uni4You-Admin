<?php

namespace FacultyInfo\UserBundle\Entity;

class Password {
	private $first;
	private $second;

	public function getFirst() {
		return $this -> first;
	}

	public function setFirst($first) {
		$this -> first = $first;
	}

	public function getSecond() {
		return $this -> second;
	}

	public function setSecond($second) {
		$this -> second = $second;
	}

}
