<?php

namespace PedidosComidas\Models\User;

use PedidosComidas\Models\AbstractDataMapper;

class UserDataMapper extends AbstractDataMapper {
	protected $entityTable = "users";

	public function insert(UserEntity $user) {
		$id = $this->databaseAdapter->insert($this->entityTable, [
			'username' => $user->username,
			'password' => $user->password,
			'email' => $user->email,
			'name' => $user->name,
			'created' => $user->created,
			'updated' => $user->updated,
		]);

		$user->id = $id;

		return $id;
	}

	public function update(UserEntity $user) {
		$affectedRows = $this->databaseAdapter->update($this->entityTable, [
			'username' => $user->username,
			'password' => $user->password,
			'email' => $user->email,
			'name' => $user->name,
			'updated' => date('Y-m-d H:i:s'),
		], "id = {$user->id}");

		return $affectedRows;
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