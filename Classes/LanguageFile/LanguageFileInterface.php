<?php
namespace FluidTYPO3\Flll\LanguageFile;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Claus Due <claus@namelesscoder.net>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * @package Flll
 * @subpackage LanguageFile
 */
interface LanguageFileInterface {

	/**
	 * Writes collected labels to file; uses stored filename if one exists,
	 * otherwise fails to write. Throws \FluidTYPO3\LanguageFile\Exception
	 * on errors; returns TRUE on success.
	 *
	 * @return boolean
	 * @throws Exception
	 */
	public function write();

	/**
	 * Adds a label+value pair to internal storage, ready to be written to
	 * file. Does not care if label exists or not; simply overwrites the
	 * stored pair regardless.
	 *
	 * @param string $labelName
	 * @param string $labelValue
	 * @return void
	 */
	public function add($labelName, $labelValue);

	/**
	 * Sets array of simple language codes; fx array('da', 'de', 'en') for
	 * which automatic LLL labels should be written. Each language code
	 * added here translates to one complete set of labels being written
	 * for that language.
	 *
	 * @param array $basicLanguageCodes
	 * @return void
	 */
	public function setLanguages(array $basicLanguageCodes);

	/**
	 * @param string $filename
	 * @return void
	 */
	public function setFilename($filename);

	/**
	 * @return string
	 */
	public function getFilename();

}
