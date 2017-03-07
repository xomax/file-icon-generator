<?php
	namespace FileIconGenerator;

	class Font
	{
		private $fontDir;
		private $font;

		public function __construct ($fontName)
		{
			$this->fontDir = __DIR__.'/fonts/';
			$this->initFont($fontName);
		}

		public function initFont ($fontName)
		{
			if (file_exists($fontName)) {
				$this->font = $fontName;
			} elseif (file_exists($this->fontDir.$fontName)) {
				$this->font = $this->fontDir.$fontName;
			}
		}

		public function getSource ()
		{
			return $this->font;
		}

	}