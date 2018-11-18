<?php

namespace PedidosComidas\Database;

use PedidosComidas\Database\PdoAdapter;
use Symfony\Component\Yaml\Yaml;

class DBService {

	private $connection;
	
	private $config;

	public function __construct() {
		$phinxConfigs = $this->getConfigsFromFile();

		$this->config = $phinxConfigs['environments']['development'];
	}

	public function getConfigsFromFile() {
		return Yaml::parseFile(__DIR__ . "/../../phinx.yml");
	}

	public function getConnection() {
		$this->connection = new PdoAdapter("{$this->config['adapter']}:host={$this->config['host']};dbname={$this->config['name']}", $this->config['user'], $this->config['pass']);

		return $this->connection;
	}
}