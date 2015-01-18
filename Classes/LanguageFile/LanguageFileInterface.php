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
