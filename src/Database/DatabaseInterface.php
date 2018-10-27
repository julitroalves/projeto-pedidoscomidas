<?php

namespace PedidosComidas\Database;

interface DatabaseInterface {
	public function connect();

	public function disconnect();

	public function prepare($query, array $options = []);

	public function execute(array $parameters = []);

	public function fetch($fetchStyle, $cursorOrientation, $cursorOffset);

	public function fetchAll($fetchStyle, $column = 0);

	public function select($table, array $bind = [], $boolOperator = 'AND');

	public function insert($table, array $bind = []);

	public function update($table, array $bind = [], $where = '');

	public function delete($table, $where = '');
}