<?php
namespace FacultyInfo\UserBundle\Service;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use FacultyInfo\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerAware;

define('ROLE_DEFAULT', 'ROLE_USER');

/**
 *
 * @author Timo Staudinger
 *
 */
class UserProvider extends ContainerAware implements UserProviderInterface {

	public function loadUserByUsername($username) {

		$repositiory = $this -> container -> get('doctrine') -> getRepository('FacultyInfoUserBundle:User');
		$query = $repositiory -> createQueryBuilder('u') -> where('u.email = :email') -> setParameter('email', $username) -> getQuery();
		$user = $query -> getOneOrNullResult();

		if ($user != null) {
			$roles[] = 'ROLE_USER';
			$user -> setRoles($roles);

			$salt = $this -> container -> getParameter('security_salt');
			$user -> setSalt($salt);

			$user -> setLoadTime(time());

			return $user;
		}

		throw new UsernameNotFoundException(sprintf('User with Email "%s" does not exist.', $username));
	}

	public function refreshUser(UserInterface $user) {
		if (!$user instanceof User) {
			throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
		}

		if ($user -> getLoadTime() > strtotime("-10 minutes")) {
			return $user;
		}

		return $this -> loadUserByUsername($user -> getEmail());
	}

	public function supportsClass($class) {
		return $class === 'FacultyInfo\UserBundle\Entity\User';
	}

}
