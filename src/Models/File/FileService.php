<?php

namespace PedidosComidas\Models\File;

use PedidosComidas\Models\AbstractService;
use PedidosComidas\Models\File\FileDataMapper;
use PedidosComidas\Models\File\FileEntity;

class FileService extends AbstractService {
	private $fileMapper;

	private $filesDirectory = '/var/www/public/files/';

	private $files = [];

	private $extensions = 'txt pdf jpeg jpg png odp doc zip';

	public function __construct($files) {
		parent::__construct();

		$adapter = $this->injector->get('DBService')->getConnection();

		$this->fileMapper = new FileDataMapper($adapter);

		$this->files = $files;
	}

	public function isValid($name) {
		$isOk = UPLOAD_ERR_OK === 0;

		return $isOk && is_uploaded_file($this->files[$name]['tmp_name']);
	}

	public function getTargetFile($name) {
		return $this->filesDirectory . trim(basename($name));
	}

	public function getMimeType($name) {
		return pathinfo($name, PATHINFO_EXTENSION);
	}

	public function isValidMimeType($targetFile) {
		$mimeType = $this->getMimeType($targetFile);

		return $mimeType && in_array($mimeType, explode(' ', $this->extensions));
	}

	public function save($formName) {
		if (!$this->isValid($formName)) {
			throw new \Exception("The file is not Valid");
		}

		$targetFile = $this->getTargetFile($this->files[$formName]['name']);

		if (!$this->isValidMimeType($targetFile)) {
			throw new \Exception("This file type is not permitted to upload.");
		}

		$moved = move_uploaded_file($this->files[$formName]['tmp_name'], $targetFile);

		if (!$moved) {
			throw new \Exception('The file cannot be moved to your server directory.');
		}

		$file = new FileEntity();

		$file->name = $this->files[$formName]['name'];
		$file->uri = $targetFile;
		$file->size = $this->files[$formName]['size'];
		$file->mime = $this->getMimeType($targetFile);
		$file->author = 1;
		$file->created = date('Y-m-d H:i:s', time());

		return $this->create($file);
	}

	public function load(array $parameters = []) {
		$files = $this->fileMapper->findAll($parameters);

		return $files;
	}

	public function findByID($id) {
		return $this->fileMapper->findByID($id);
	}

	public function create(FileEntity $file) {		
		$this->fileMapper->insert($file);

		return $file;
	}

	public function delete(FileEntity $file) {
		return $this->fileMapper->delete($file);
	}
}