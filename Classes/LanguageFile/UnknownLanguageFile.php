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
class UnknownLanguageFile extends AbstractLanguageFile implements LanguageFileInterface {

	/**
	 * Override - don't attempt to save unknown formats.
	 *
	 * @return boolean
	 */
	public function write() {
		return TRUE;
	}

}
