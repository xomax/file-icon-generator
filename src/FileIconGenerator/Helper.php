<?php
	namespace xomax\FileIconGenerator;

	class Helper
	{
		private $builder;

		public function __construct ()
		{
			$this->builder = new Builder();
		}

		/**
		 * Create a 16x16 icon for the given extension
		 *
		 * @param string $ext extension name
		 * @param string $out output file (png)
		 */
		public function create16x16($ext, $out)
		{
			$generator = $this->getGenerator16($out);
			$this->generate($generator, $ext);
		}

		/**
		 * Create a 32x32 icon for the given extension
		 *
		 * @param string $ext extension name
		 * @param string $out output file (png)
		 */
		public function create32x32($ext, $out)
		{
			$generator = $this->getGenerator32($out);
			$this->generate($generator, $ext);
		}

		private function generate (Generator $generator, $ext)
		{
			if (is_string($ext)) {
				$ext = [$ext];
			}
			if (is_array($ext)) {
				foreach ($ext as $ex) {
					$generator->generate($ex, $this->builder);
				}
			}
		}

		/**
		 * Create icons for all known extension from mime.types
		 *
		 * @param string $outdir directory to otput the files to
		 */
		public function createAll($outdir)
		{
			@mkdir($outdir);
			@mkdir("$outdir/16x16");
			@mkdir("$outdir/32x32");

			$ext = $this->builder->getExtensions();
			$this->create16x16($ext, "$outdir/16x16");
			$this->create32x32($ext, "$outdir/32x32");
		}

		public function getGenerator16 ($out)
		{
			return new Generator('16x16', $out);
		}

		public function getGenerator32 ($out)
		{
			$generator = new Generator('32x32', $out);
			$generator
				->setBox([4, 22, 26, 28])
				->setFont(new Font('pf_tempesta_five.ttf'))
				->setBevel('border');
			return $generator;
		}

	}