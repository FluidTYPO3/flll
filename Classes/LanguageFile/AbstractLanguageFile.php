<?php
namespace FluidTYPO3\Flll\LanguageFile;

/*
 * This file is part of the FluidTYPO3/Flll project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

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
