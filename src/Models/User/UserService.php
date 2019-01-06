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

	public function userPasswordVerify($passwordToVerify, $hash) {
		return password_verify($passwordToVerify, $hash);
	}

	public function finalizeLogin(UserEntity $user) {
		$userData = (array) $user;

		unset($userData['password']);

		$this->sessionStore->set('user', $userData);

		return $user;
	}

	public function create(array $data) {

		if ($this->findByUsername($data['username'])) {
			throw new \Exception("Este username já existe!");
		}

		if ($this->findByEmail($data['email'])) {
			throw new \Exception("Este e-mail já está sendo usado!");
		}

		if ($data['password'] !== $data['password2']) {
			throw new \Exception("A confirmação de senha falhou, senhas diferem!");
		}

		$data['password'] = password_hash($data['password'], PASSWORD_ARGON2I);
		
		$data['created'] = date('Y-m-d H:i:s');

		$user = new UserEntity(
			$data['username'],
			$data['password'],
			$data['email'],
			$data['name'],
			$data['created']
		);

		$this->usersMapper->insert($user);

		return $user;
	}

	public function edit(UserEntity $user, array $edit) {

		if ($user->id != $edit['id']) {
			throw new \Exception("O id do usuário é inválido.");
		}

		if ($user->username !== $edit['username'] && $this->findByUsername($edit['username'])) {
			throw new \Exception("Este username já existe!");
		}

		if ($user->email !== $edit['email'] && $this->findByEmail($edit['email'])) {
			throw new \Exception("Este e-mail já está sendo usado!");
		}

		$currentPasswordEmpty = empty($edit['current_password']);
		$passwordVerified = $this->userPasswordVerify($edit['current_password'], $user->password);
		if ((!$currentPasswordEmpty && $passwordVerified) && $edit['password'] !== $edit['password2']) {
			throw new \Exception("A confirmação de senha falhou, senhas diferem!");
		}

		$user->username = $edit['username'];
		$user->name = $edit['name'];
		$user->email = $edit['email'];

		$user->password = $edit['password'] ?? $edit['current_password'];

		$user->password = password_hash($user->password, PASSWORD_ARGON2I);

		$this->usersMapper->update($user);

		return $user;
	}

	public function load(array $parameters = []) {
		return $this->usersMapper->findAll($parameters);
	}

	public function findById(int $id) {
		return $this->usersMapper->findById($id);
	}

	public function findByUsername(string $username) {
		$users = $this->load(['username' => $username]);

		if (empty($users) || sizeof($users) == 0)
			return null;

		$user = array_shift($users);

		return $user;
	}

	public function findByEmail(string $email) {
		$users = $this->load(['email' => $email]);

		if (empty($users) || sizeof($users) == 0)
			return null;

		$user = array_shift($users);

		return $user;
	}

}