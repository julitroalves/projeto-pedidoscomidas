<?php

namespace PedidosComidas\Models\User;

class UserEntity {
	public $id;
	public $username;
	public $password;
	public $email;
	public $name;
	public $created;
	public $updated;

	public function __construct($username, $password, $email, $name, $created, $updated) {
		$this->username = $username;
		$this->password = $password;
		$this->email = $email;
		$this->name = $name;
		$this->created = $created;
		$this->updated = $updated;
	}
}