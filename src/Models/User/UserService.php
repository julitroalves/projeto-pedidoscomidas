<?php

namespace PedidosComidas\Models\User;

use PedidosComidas\Models\AbstractService;
use PedidosComidas\Models\User\UserDataMapper;
use PedidosComidas\Models\User\UserEntity;

class UserService extends AbstractService {
		
	private $sessionStore;

	private $usersMapper;

	public function __construct() {
		parent::__construct();
		
		$adapter = $this->injector->get('DBService')->getConnection();

		$this->sessionStore = $this->injector->get('SessionStore');
		
		$this->usersMapper = new UserDataMapper($adapter);
	}

	public function login(array $formData = []) {
		$user = $this->findByUsername($formData['username']);

		if (!$user)
			throw new \Exception("Usuário não encontrado.");

		$passwordVerified = password_verify($formData['password'], $user->password);

		if (!$passwordVerified)
			throw new \Exception("O usuário ou a senha estão incorretos.");

		$this->finalizeLogin($user);
	}

	public function finalizeLogin(UserEntity $user) {
		$userData = (array) $user;

		unset($userData['password']);

		$this->sessionStore->set('user', $userData);

		return $user;
	}

	public function createUser(array $data) {

		$user = new UserEntity(
			$data['username'],
			$data['password'],
			$data['email'],
			$data['name'],
			$data['created'],
			$data['updated']
		);

		$this->usersMapper->insert($user);

		return $user;
	}

	public function load(array $parameters = []) {
		return $this->usersMapper->findAll($parameters);
	}

	public function findByUsername(string $username) {
		$users = $this->load(['username' => $username]);

		if (empty($users) || sizeof($users) == 0)
			return null;

		$user = array_shift($users);

		return $user;
	}

}