<?php
namespace FluidTYPO3\Flll\Localization;
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
use FluidTYPO3\Flll\Utility\LanguageFileUtility;
use TYPO3\CMS\Core\Localization\Exception\FileNotFoundException;
use TYPO3\CMS\Core\Localization\Parser\LocalizationParserInterface;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * @package Flll
 * @subpackage LanguageFile
 */
class LocalizationFactory extends \TYPO3\CMS\Core\Localization\LocalizationFactory {

	/**
	 * Returns parsed data from a given file and language key.
	 *
	 * @param string $fileReference Input is a file-reference (see \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName). That file is expected to be a supported locallang file format
	 * @param string $languageKey Language key
	 * @param string $charset Character set (option); if not set, determined by the language key
	 * @param integer $errorMode Error mode (when file could not be found): 0 - syslog entry, 1 - do nothing, 2 - throw an exception
	 * @param boolean $isLocalizationOverride TRUE if $fileReference is a localization override
	 * @return array|boolean
	 */
	public function getParsedData($fileReference, $languageKey, $charset, $errorMode, $isLocalizationOverride = FALSE) {
		$data = parent::getParsedData($fileReference, $languageKey, $charset, $errorMode, $isLocalizationOverride);
		if (FALSE === $this->isWhitelisted($fileReference) || TRUE === $this->isBlacklisted($fileReference)) {
			return $data;
		}
		$proxy = LanguageFileUtility::createProxyForFile($fileReference, (array) $data);
		return array($languageKey => $proxy);
	}

	/**
	 * @param string $filename
	 * @return boolean
	 */
	protected function isWhitelisted($filename) {
		$filename = GeneralUtility::getFileAbsFileName($filename);
		$whitelist = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['flll']['setup']['whitelist'];
		if (0 < count($whitelist)) {
			foreach ($whitelist as $whitelistedExtensionKey) {
				$whitelistedExtensionFolder = ExtensionManagementUtility::extPath($whitelistedExtensionKey);
				if (0 === strpos($filename, $whitelistedExtensionFolder)) {
					return TRUE;
				}
			}
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * @param string $filename
	 * @return boolean
	 */
	protected function isBlacklisted($filename) {
		$filename = GeneralUtility::getFileAbsFileName($filename);
		$blacklist = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['flll']['setup']['blacklist'];
		if (0 < count($blacklist)) {
			foreach ($blacklist as $blacklistedExtensionKey) {
				$blacklistedExtensionFolder = ExtensionManagementUtility::extPath($blacklistedExtensionKey);
				if (0 === strpos($filename, $blacklistedExtensionFolder)) {
					return TRUE;
				}
			}
			return FALSE;
		}
		return (FALSE !== strpos($filename, '/typo3/sysext/'));
	}

}
