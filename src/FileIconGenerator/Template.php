<?php
	namespace xomax\FileIconGenerator;

	class Template
	{
		private $templateDir;

		public function __construct ()
		{
			$this->templateDir = __DIR__.'/templates/';
		}

		public function get ($ext, $size, $mime)
		{
			// try to match extension first
			if(file_exists($this->templateDir."$size/extension-$ext.png")) {
				return $this->templateDir."$size/extension-$ext.png";
			}

			// find the mimetype
			$mime = preg_split('/[\/\.\-]/', $mime);

			// try to find as exact match as possible
			while (count($mime)) {
				$test = join('-', $mime);
				if(file_exists($this->templateDir."$size/$test.png")) {
					return $this->templateDir."$size/$test.png";
				}
				array_pop($mime);
			}

			return $this->templateDir."$size/application.png";
		}
	}