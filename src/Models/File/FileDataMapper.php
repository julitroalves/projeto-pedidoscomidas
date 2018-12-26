<?php

namespace PedidosComidas\Models\File;

use PedidosComidas\Models\AbstractDataMapper;

class FileDataMapper extends AbstractDataMapper {
	protected $entityTable = 'file';

	public function insert(FileEntity $file) {
		$id = $this->databaseAdapter->insert($this->entityTable, [
			'name' => $file->name,
			'uri' => $file->uri,
			'size' => $file->size,
			'mime' => $file->mime,
			'author' => $file->author,
			'created' => $file->created,
			'status' => $file->status,
		]);

		$file->id = $id;

		return $id;
	}

	public function delete(FileEntity $file) {
		return $this->databaseAdapter->delete($this->entityTable, "id = {$file->id}");
	}

	protected function createEntity($row) {
		$file = new FileEntity();

		$file->name = $row['name'];
		$file->uri = $row['uri'];
		$file->size = $row['size'];
		$file->mime = $row['mime'];
		$file->author = $row['author'];
		$file->created = $row['created'];
		$file->status = $row['status'];

		if (isset($row['id'])) {
			$file->id = $row['id'];
		}

		return $file;
	}
}