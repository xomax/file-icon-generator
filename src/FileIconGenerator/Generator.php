<?php
	namespace FileIconGenerator;

	class Generator
	{
		/**
		 * @var Font
		 */
		private $font;
		private $size;
		private $box = [0, 7, 15, 13];
		private $outputDir;
		private $fontSize = 6;
		private $bevel = 'corner';

		public function __construct ($size, $dir)
		{
			$this->size = $size;
			$this->outputDir = $dir;
		}

		public function setBox ($box)
		{
			$this->box = $box;
			return $this;
		}

		public function setBevel ($bevel)
		{
			$this->bevel = $bevel;
			return $this;
		}

		public function setFont (Font $font, $size = 6)
		{
			$this->font = $font;
			$this->fontSize = floatval($size);
			return $this;
		}

		public function generate ($ext, Builder $builder)
		{
			$tpl = $builder->getTemplate($ext, $this->size);
			$rgb = $builder->getColor($ext);
			$this->loadFont();

			$im = imagecreatefrompng($tpl);
			imagesavealpha($im, true);

			$this->drawColorBox($im, $rgb);
			$this->drawText($im, strtoupper($ext));

			imagepng($im, $this->outputDir."/$ext.png", 9);
			imagedestroy($im);
		}

		/**
		 * Draws the extension text
		 *
		 * @param        $im
		 * @param string $text
		 */
		private function drawText ($im, $text)
		{
			list($left, $top, $right, $bottom) = $this->box;
			$fontSource = $this->font->getSource();

			// calculate offset for centered text
			$bbox   = imagettfbbox($this->fontSize, 0, $fontSource, $text);
			$width  = $bbox[2];
			$offset = floor(($right - $left  - $width) / 2.0);
			$offset = $left + $offset;

			// write text
			$c = imagecolorallocate($im, 255, 255, 255);
			imagettftext(
				$im, $this->fontSize, 0, $offset, $bottom, -1 * $c,
				$fontSource,
				$text
			);
		}

		/**
		 * Draws the colored box for the extension text
		 *
		 * @param        $im
		 * @param array  $rgb
		 */
		private function drawColorBox ($im, $rgb)
		{
			list($left, $top, $right, $bottom) = $this->box;
			list($r, $g, $b) = $rgb;

			for($x = $left; $x <= $right; $x++) {
				for($y = $top; $y <= $bottom; $y++) {

					// Alpha transparency for bevels
					$alpha = 0;
					if($this->bevel == 'corner') {
						if($x == $left || $x == $right) {
							switch($y) {
								case $top:
								case $bottom:
									$alpha = 64;
									break;
								case $top + 1:
								case $bottom - 1:
									$alpha = 32;
									break;
							}
						} elseif(
							($x == $left + 1 || $x == $right - 1) &&
							($y == $top || $y == $bottom)
						) {
							$alpha = 32;
						} elseif ( $y == $right ) {
							$alpha = 32;
						}
					} else if($this->bevel == 'border') {
						if($x == $left || $x == $right) {
							$alpha = 32;
						}
					}

					$c = imagecolorallocatealpha($im, $r, $g, $b, $alpha);
					imagesetpixel($im, $x, $y, $c);
				}
			}
		}

		private function loadFont ()
		{
			if ($this->font === null) {
				$this->font = new Font('pf_tempesta_five_compressed.ttf');
			}
		}
	}