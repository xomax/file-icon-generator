<?php
	namespace FileIconGenerator;

	class Color
	{

		private $mimeTypes;

		private $colors = [
			// used if nothing matches
			'' => '#33333',

			// basic mime types
			'image' => '#999900',
			'video' => '#990099',
			'audio' => '#009900',
			'text' => '#999999',
			'application' => '#990000',
			'chemical' => '#009999',

			// self defined types
			'package' => '#996600',
			'geo' => '#99CC00',
			'document-office' => '#009999',
			'document-print' => '#666666',
			'text-code' => '#336699',
		];

		public function __construct (MimeTypes $mimeTypes)
		{
			$this->mimeTypes = $mimeTypes;
		}

		/**
		 * Define a color for a mime type
		 *
		 * Colors can be given as HTML hex colors
		 *
		 * @param string $mime
		 * @param string $color
		 */
		public function setColor($mime, $color)
		{
			$this->colors[$mime] = $color;
		}

		/**
		 * @param string $ext
		 * @return array RGB
		 */
		public function get ($ext)
		{
			// try to match extension first
			if(isset($this->colors["extension-$ext"])) {
				return $this->hex2rgb($this->colors["extension-$ext"]);
			}

			// find the mimetype
			$mime = $this->mimeTypes->getType($ext);
			$mime = preg_split('/[\/\.\-]/', $mime);

			// try to find as exact match as possible
			while(count($mime)) {
				$test = join('-', $mime);
				if(isset($this->colors[$test])) {
					return $this->hex2rgb($this->colors[$test]);
				}
				array_pop($mime);
			}

			return $this->hex2rgb($this->colors['']);
		}

		/**
		 * Convert a hex color code to an rgb array
		 *
		 * @param string $hex HTML color code
		 * @return array RGB integers as array
		 */
		private function hex2rgb($hex)
		{
			// strip hash
			$hex = str_replace('#', '', $hex);

			// normalize short codes
			if(strlen($hex) == 3) {
				$hex = substr($hex, 0, 1).
					substr($hex, 0, 1).
					substr($hex, 1, 1).
					substr($hex, 1, 1).
					substr($hex, 2, 1).
					substr($hex, 2, 1);
			}

			// calc rgb
			return array(
				hexdec(substr($hex, 0, 2)),
				hexdec(substr($hex, 2, 2)),
				hexdec(substr($hex, 4, 2))
			);
		}
	}
