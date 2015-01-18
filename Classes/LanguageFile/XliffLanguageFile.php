<?php
namespace FluidTYPO3\Flll\LanguageFile;

/*
 * This file is part of the FluidTYPO3/Flll project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

/**
 * @package Flll
 * @subpackage LanguageFile
 */
class XliffLanguageFile extends AbstractLanguageFile implements LanguageFileInterface {

	/**
	 * Writes collected labels to file; uses stored filename if one exists,
	 * otherwise fails to write. Throws \FluidTYPO3\LanguageFile\Exception
	 * on errors; returns TRUE on success.
	 *
	 * @return boolean
	 * @throws Exception
	 */
	public function write() {
		foreach ($this->newLabels as $definition) {
			$this->languageFileService->writeLanguageLabel($this->getFilename(), $definition);
		}
	}

}
