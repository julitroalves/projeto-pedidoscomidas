<?php

namespace PedidosComidas\Models\File;

use PedidosComidas\Models\AbstractEntity;

class FileEntity extends AbstractEntity {
	public $id;
	public $name;
	public $uri;
	public $size;
	public $mime;
	public $author;
	public $created;
	public $status = 0;


	public function getUrl() {
		return $this->getBaseUrl() . '/files/' . $this->name;
	}
}
