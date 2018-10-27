<?php

namespace PedidosComidas\Database;

class PdoAdapter implements DatabaseInterface  {
	protected $config = [];

	protected $connection;

	protected $statement;

	protected $fetchMode = \PDO::FETCH_ASSOC;

	public function __construct($dsn, $username = null, $password = null, $driverOptions = []) {
		$this->config = \compact("dsn", "username", "password", "driverOptions");
	}

	public function getStatement() {
		if ($this->statement === null) {
			$message = "There is no PDOStatement object for use.";
			throw new \PDOException($message);
		}

		return $this->statement;
	}

	public function connect() {
		if ($this->connection) {
			return $this->connection;
		}

		try {
			$this->connection = new \PDO(
				$this->config['dsn'],
				$this->config['username'],
				$this->config['password'],
				$this->config['driverOptions']
			);

			$this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

			$this->connection->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);

			return $this->connection;
		} catch (\PDOException $e) {
			throw new \RunTimeException($e->getMessage());
		}
	}

	public function disconnect() {
		$this->connection = null;
	}

	public function prepare($query, array $options = []) {
		$this->connect();

		try {
			$this->statement = $this->connection->prepare($query, $options);

			return $this;
		} catch (\PDOException $e) {
			throw new \RunTimeException($e->getMessage());
		}
	}

	public function execute(array $parameters = []) {
		try {
			$this->getStatement()->execute($parameters);

			return $this;
		} catch (\PDOException $e) {
			throw new \RunTimeException($e->getMessage());
		}
	}

	public function getAffectedRows() {
		try {
			return $this->getStatement()->rowCount();
		} catch (\PDOException $e) {
			throw new \RunTimeException($e->getMessage());
		}
	}

	public function getLastInsertId($name = null) {
		$this->connect();

		$this->connection->lastInsertId($name);
	}

	public function fetch($fetchStyle, $cursorOrientation = null, $cursorOffset = null) {
		$fetchStyle = $fetchStyle ?? $this->fetchMode;

		try {
			return $this->getStatement()->fetch($fetchStyle, $cursorOrientation, $cursorOffset);
		}  catch (\PDOException $e) {
			throw new \RunTimeException($e->getMessage());
		}
	}

	public function fetchAll($fetchStyle, $column = 0) {
		$fetchStyle = $fetchStyle ?? $this->fetchMode;

		try {
			return $fetchStyle === \PDO::FETCH_COLUMN
				? $this->getStatement()->fetchAll($fetchStyle, $column)
				: $this->getStatement()->fetchAll($fetchStyle);
		} catch (\PDOException $e) {
			throw new \RunTimeException($e->getMessage());
		}
	}

	public function prepareBind(array $bind) {
		$params = [
			'bind' => [],
			'where' => [],
		];

		if (empty($bind))
			return $params; 

		$where = [];
		foreach ($bind as $col => $value) {
			unset($bind[$col]);

			$bind[":{$col}"] = $value;
			$where[] = "{$col} = :{$col}";
		}

		$params = [
			'bind' => $bind,
			'where' => $where
		];

		return $params;
	}

	public function select($table, array $bind = [], $boolOperator = 'AND') {
		$params = $this->prepareBind($bind);

		$where = '';
		if ($params['where']) {
			$whereValues = implode(" {$boolOperator} ", $params['where']);

			$where = ($params['bind']) ? " WHERE {$whereValues}" : "";
		}

		$query = "SELECT * FROM {$table} {$where}";

		$this->prepare($query)->execute($params['bind']);

		return $this;
	}

	public function insert($table, array $bind = []) {
		$cols = implode(", ", array_keys($bind));
		$values = implode(", :", array_keys($bind));

		$params = $this->prepareBind($bind);

		$query = "INSERT INTO {$table} ({$cols}) VALUES (:{$values})";

		return $this->prepare($query)
					->execute($params['bind'])
					->getLastInsertId();
	}

	public function update($table, array $bind = [], $where = "") {
		$params = $this->prepareBind($bind);

		$set = implode(', ', $params['where']);
		
		$where = ($where) ? " WHERE {$where} " : "";

		$query = "UPDATE {$table} SET {$set} {$where}";

		return $this->prepare($query)
				->execute($params['bind'])
				->getAffectedRows();
	}

	public function delete($table, $where = "") {
		$where = ($where) ? " WHERE {$where} " : "";

		$query = "DELETE FROM {$table} {$where}";

		return $this->prepare($query)
				->execute()
				->getAffectedRows();
	}
}