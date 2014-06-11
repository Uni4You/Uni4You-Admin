<?php

namespace FacultyInfo\UserBundle\Entity;

class Password {
	private $password;

	public function getPassword() {
		return $this -> password;
	}

	public function setPassword($password) {
		$this -> password = $password;
	}

}
