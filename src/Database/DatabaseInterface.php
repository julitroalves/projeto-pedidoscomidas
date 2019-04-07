<?php

namespace PedidosComidas\Database;

interface DatabaseInterface {

	public function connect();

	public function disconnect();

	public function prepare(string $query, array $options = []);

	public function execute(array $parameters = []);

	public function fetch($fetchMode = "", $cursorOrientation = null, $cursorOffset = null);

	public function fetchAll($fetchMode = "", $column = 0);

	public function select($table, array $bind = [], string $boolOperator = 'AND', array $orderBy = []);

	public function insert($table, array $bind = []);

	public function update($table, array $bind = [], string $where = "");

	public function delete($table, string $where = "");
}