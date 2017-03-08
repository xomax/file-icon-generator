<?php
	/**
	 * Class FileIconBuilder
	 *
	 * Creates icons based on an file extension name and colors/templates associated with
	 * mime types
	 */

	namespace xomax\FileIconGenerator;

	class Builder {

		/**
		 * @var MimeTypes
		 */
		private $mimeTypes;

		/**
		 * @var Template
		 */
		private $template;

		/**
		 * @var Color
		 */
		private $color;

		/**
		 * Constructor
		 *
		 * Initializes the default colors
		 */
		public function __construct() {
			$this->mimeTypes = new MimeTypes();
			$this->template = new Template();
			$this->color = new Color($this->mimeTypes);
		}

		/**
		 * Define a color for a mime type
		 *
		 * Colors can be given as HTML hex colors
		 *
		 * @param string $mime
		 * @param string $color
		 */
		public function setColor($mime, $color) {
			$this->color->setColor($mime, $color);
		}

		/**
		 * @return array
		 */
		public function getExtensions ()
		{
			return $this->mimeTypes->getKeys();
		}

		/**
		 * @param string $ext
		 * @param string $size
		 * @return string
		 */
		public function getTemplate ($ext, $size)
		{
			return $this->template->get($ext, $size, $this->mimeTypes->getType($ext));
		}

		/**
		 * @param string $ext
		 * @return array RGB
		 */
		public function getColor ($ext)
		{
			return $this->color->get($ext);
		}
	}
