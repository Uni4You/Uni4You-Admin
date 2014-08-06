<?php

namespace FacultyInfo\UserBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Doctrine\ORM\Mapping as ORM;

class User implements UserInterface, EquatableInterface {
	private $id;
	private $name;
	private $email;
	private $password;

	private $salt;
	private $roles;
	private $loadTime;

	/**
	 * Set id
	 *
	 * @param string $id
	 * @return User
	 */
	public function setId($id) {
		$this -> id = $id;

		return $this;
	}

	/**
	 * Get id
	 *
	 * @return string
	 */
	public function getId() {
		return $this -> id;
	}

	/**
	 * Set name
	 *
	 * @param string $name
	 * @return User
	 */
	public function setName($name) {
		$this -> name = $name;

		return $this;
	}

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function getName() {
		return $this -> name;
	}

	/**
	 * Set email
	 *
	 * @param string $email
	 * @return User
	 */
	public function setEmail($email) {
		$this -> email = $email;

		return $this;
	}

	/**
	 * Get email
	 *
	 * @return string
	 */
	public function getEmail() {
		return $this -> email;
	}

	/**
	 * Set password
	 *
	 * @param string $password
	 * @return User
	 */
	public function setPassword($password) {
		$this -> password = $password;

		return $this;
	}

	/**
	 * Get password
	 *
	 * @return string
	 */
	public function getPassword() {
		return $this -> password;
	}

	public function setRoles($roles) {
		$this -> roles = $roles;
	}

	public function getRoles() {
		return $this -> roles;
	}

	public function eraseCredentials() {
	}

	public function isEqualTo(UserInterface $user) {
		if (!$user instanceof User) {
			return false;
		}

		if ($this -> email !== $user -> getEmail()) {
			return false;
		}

		return true;
	}

	public function getUsername() {
		return $this -> getEmail();
	}

	public function getSalt() {
		return $this -> salt;
	}

	public function setSalt($salt) {
		$this -> salt = $salt;
	}

	public function setLoadTime($loadTime) {
		$this -> loadTime = $loadTime;
	}

	public function getLoadTime() {
		return $this -> loadTime;
	}

}
