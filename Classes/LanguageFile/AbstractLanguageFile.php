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
use FluidTYPO3\Flll\Service\LanguageFileService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @package Flll
 * @subpackage LanguageFile
 */
abstract class AbstractLanguageFile implements LanguageFileInterface {

	/**
	 * @var LanguageFileService
	 */
	protected $languageFileService;

	/**
	 * Storage: language codes for which labels must be written.
	 * Empty by default, implying only default language gets done.
	 *
	 * @var array
	 */
	protected $languages = array('default');

	/**
	 * @var string
	 */
	protected $filename;

	/**
	 * Key=>value pairs of existing labels which will not be written
	 * to the file when saved.
	 *
	 * @var array
	 */
	protected $labels = array();

	/**
	 * New labels which will be written to file.
	 *
	 * @var array
	 */
	protected $newLabels = array();

	/**
	 * @param LanguageFileService $languageFileService
	 * @return void
	 */
	public function injectLanguageFileService(LanguageFileService $languageFileService) {
		$this->languageFileService = $languageFileService;
	}

	/**
	 * @param array $basicLanguageCodes
	 * @return void
	 */
	public function setLanguages(array $basicLanguageCodes) {
		$this->languages = $basicLanguageCodes;
	}

	/**
	 * @return array
	 */
	public function getLanguages() {
		return (array) $this->languages;
	}

	/**
	 * @param string $filename
	 * @return void
	 */
	public function setFilename($filename) {
		$this->filename = $filename;
	}

	/**
	 * @return string
	 */
	public function getFilename() {
		return GeneralUtility::getFileAbsFileName($this->filename);
	}

	/**
	 * Writes collected labels to file; uses stored filename if one exists,
	 * otherwise fails to write. Throws \FluidTYPO3\LanguageFile\Exception
	 * on errors; returns TRUE on success.
	 *
	 * @return boolean
	 * @throws Exception
	 */
	public function write() {
		foreach ($this->newLabels as $label => $value) {
			$this->languageFileService->writeLanguageLabel($this->getFilename(), $label);
		}
	}

	/**
	 * Adds a label+value pair to internal storage; gets written to file.
	 *
	 * @param string $labelName
	 * @param string $labelValue
	 * @return void
	 */
	public function add($labelName, $labelValue) {
		$this->newLabels[$labelName] = $labelValue;
	}

	/**
	 * Destructor
	 */
	public function __destruct() {
		$this->write();
	}

}
