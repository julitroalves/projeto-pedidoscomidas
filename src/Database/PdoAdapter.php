<?php

namespace PedidosComidas\Database;

class PdoAdapter implements DatabaseInterface {
	protected $config = [];

	protected $connection;

	protected $statement;

	protected $fetchMode = \PDO::FETCH_ASSOC;

	public function __construct($dsn, $username, $password, $driverOptions = []) {
		$this->config = \compact("dsn", "username", "password", "driverOptions");
	}

	public function getStatement() {
		if (!$this->statement) {
			$message = "There is no PDOStatement Object for use.";
			throw new \Exception($message);
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

	public function query($query) {
		$this->connect();
		
		try {
			return $this->connection->query($query);
		} catch (\PDOException $e) {
			throw new \RunTimeException($e->getMessage());
		}
	}

	public function prepare(string $query, array $options = []) {
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
		}  catch (\PDOException $e) {
			throw new \RunTimeException($e->getMessage());
		}
	}

	public function fetch($fetchMode = null, $cursorOrientation = null, $cursorOffset = null) {
		$fetchMode = $fetchMode ?? $this->fetchMode;

		try {
			return $this->getStatement()->fetch($fetchMode, $cursorOrientation, $cursorOffset);
		}  catch (\PDOException $e) {
			throw new \RunTimeException($e->getMessage());
		}
	}

	public function fetchAll($fetchMode = null, $column = 0) {
		$fetchMode = $fetchMode ?? $this->fetchMode;

		try {
			return ($fetchMode === \PDO::FETCH_COLUMN)
				? $this->getStatement()->fetchAll($fetchMode, $column)
				: $this->getStatement()->fetchAll($fetchMode);
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

	public function getLastInsertId($name = "") {
		try {
			return $this->connection->lastInsertId();
		} catch (\PDOException $e) {
			throw new \RunTimeException($e->getMessage());
		}
	}

	public function prepareBind(array $bind = []) {
		$params = [
			'where' => [],
			'bind' => [],
		];

		if (empty($bind))
			return $params;

		foreach ($bind as $col => $value) {
			$params['bind'][":{$col}"] = $value;

			$params['where'][] = "{$col} = :{$col}";
		}

		return $params;
	}

	public function select($table, array $bind = [], string $boolOperator = 'AND')  {
		$params = $this->prepareBind($bind);

		$where = "";
		if ($params['where']) {
			$wherePieces = implode(" {$boolOperator} ", $params['where']);

			$where = " WHERE {$wherePieces}";
		}

		$query = "SELECT * FROM {$table} {$where}";

		return $this->prepare($query)->execute($params['bind']);
	}

	public function insert($table, array $bind = []) {
		$columns = implode(', ', array_keys($bind));
		$values = implode(', :', array_keys($bind));		

		$params = $this->prepareBind($bind);

		$query = "INSERT INTO {$table} ({$columns}) VALUES (:{$values})";
		
		return $this->prepare($query)
					->execute($params['bind'])
					->getLastInsertId();
	}

	public function update($table, array $bind = [], string $where = "") {
		$params = $this->prepareBind($bind);

		$set = "";
		if ($params['where']) {
			$set = implode(', ', $params['where']);
		}

		$query = "UPDATE {$table} SET {$set} {$where}";

		return $this->prepare($query)
					->execute($params['bind'])
					->getAffectedRows();
	}

	public function delete($table, string $where = "") {
		$where = !empty($where) ? " WHERE {$where} " : "";

		$query = "DELETE FROM {$table} {$where}";

		return $this->prepare($query)
					->execute()
					->getAffectedRows();
	}
}