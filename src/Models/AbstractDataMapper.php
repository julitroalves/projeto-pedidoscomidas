<?php

namespace PedidosComidas\Models;

use PedidosComidas\Database\DatabaseInterface;

abstract class AbstractDataMapper {
	protected $entityTable;

	protected $databaseAdapter;

	public function __construct(DatabaseInterface $databaseAdapter) {
		$this->databaseAdapter = $databaseAdapter;
	}

	public function findById($id) {
		$row = $this->databaseAdapter->select($this->entityTable, ['id' => $id])->fetchAll();

		if (!$row) {
			return null;
		}

		return $this->createEntity($row[0]);
	}

	public function findAll(array $conditions = []) {
		$rows = $this->databaseAdapter->select($this->entityTable, $conditions)->fetchAll();

		if (!$rows) {
			return null;
		}

		$entities = [];
		foreach ($rows as $row) {
			$entities[] = $this->createEntity($row);
		}


		return $entities;
	}

	abstract protected function createEntity($row);
}