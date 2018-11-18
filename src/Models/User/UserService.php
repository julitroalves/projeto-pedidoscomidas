<?php

namespace PedidosComidas\Models\User;

use PedidosComidas\Models\AbstractService;
use PedidosComidas\Models\User\UserDataMapper;
use PedidosComidas\Models\User\UserEntity;

class UserService extends AbstractService {

	private $dbService;
	
	private $adapter;

	public function __construct() {
		parent::__construct();
		
		$this->dbService = $this->injector->get('DBService');

		$this->adapter = $this->dbService->getConnection();
	}

	public function createUser(array $data) {
		$usersMapper = new UserDataMapper($this->adapter);

		$user = new UserEntity(
			$data['username'],
			$data['password'],
			$data['email'],
			$data['name'],
			$data['created'],
			$data['updated']
		);

		$usersMapper->insert($user);

		return $user;
	}

	public function load(array $parameters = []) {
		$usersMapper = new UserDataMapper($this->adapter);

		$users = $usersMapper->findAll($parameters);

		return $users;
	}

}