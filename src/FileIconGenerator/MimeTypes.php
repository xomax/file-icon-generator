<?php

	namespace xomax\FileIconGenerator;

	class MimeTypes
	{
		private $mimeTypes = null;
		private $mimeFile;

		public function __construct ()
		{
			$this->mimeFile = __DIR__.'/config/mime.types';
		}

		public function getMimeTypes ()
		{
			$this->loadMimeTypes();
			return $this->mimeTypes;
		}

		public function getKeys ()
		{
			$this->loadMimeTypes();
			return array_keys($this->mimeTypes);
		}

		public function getType ($ext)
		{
			$this->loadMimeTypes();
			if ($this->typeExists($ext)) {
				return $this->mimeTypes[$ext];
			}
			return 'application/octet-stream';
		}

		public function typeExists ($ext)
		{
			$this->loadMimeTypes();
			return array_key_exists($ext, $this->mimeTypes);
		}

		/**
		 * Load mimetypes for extensions
		 */
		private function loadMimeTypes ()
		{
			if ($this->mimeTypes === null)
			{
				$this->mimeTypes = [];

				$lines = file($this->mimeFile);
				foreach($lines as $line) {
					// skip comments
					$line = preg_replace('/#.*$/', '', $line);
					$line = trim($line);
					if($line === '') continue;

					$exts = preg_split('/\s+/', $line);
					$mime = array_shift($exts);
					if(!$exts) continue;
					foreach($exts as $ext) {
						if(empty($ext)) continue;
						if(strlen($ext) > 4) continue; // we only handle 4 chars or less
						$this->mimeTypes[$ext] = $mime;
					}
				}
			}
		}

		/**
		 * @param string $mimeFile
		 * @return MimeTypes
		 */
		public function setMimeFile ( $mimeFile ) {
			$this->mimeFile = $mimeFile;
			return $this;
		}


	}