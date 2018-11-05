<?php

namespace PedidosComidas\Models\User;

use PedidosComidas\Models\AbstractDataMapper;

class UserDataMapper extends AbstractDataMapper {
	protected $entityTable = "users";

	public function insert(array $row) {
		$id = $this->databaseAdapter->insert($this->entityTable, $row);

		$row['id'] = $id;

		return $this->createEntity($row);
	}

	protected function createEntity($row) {
		$user = new UserEntity(
			$row['username'],
			$row['password'],
			$row['email'],
			$row['name'],
			$row['created'],
			$row['updated']
		);

		if (isset($row['id'])) {
			$user->id = $row['id'];
		}

		return $user;
	}
}