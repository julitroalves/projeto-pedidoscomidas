<?php

namespace PedidosComidas\Models\File;

class FileEntity {
	public $id;
	public $name;
	public $uri;
	public $size;
	public $mime;
	public $author;
	public $created;
	public $status = 0;


	public function getUrl() {
		return 'http://' . $_SERVER['SERVER_NAME'] . '/files/' . $this->name;
	}
}
