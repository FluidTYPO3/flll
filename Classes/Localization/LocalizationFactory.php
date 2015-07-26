<?php
namespace FluidTYPO3\Flll\Localization;

/*
 * This file is part of the FluidTYPO3/Flll project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use FluidTYPO3\Flll\Utility\LanguageFileUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
	public function getParsedData($fileReference, $languageKey, $charset = '', $errorMode = 0, $isLocalizationOverride = FALSE) {
		$data = parent::getParsedData($fileReference, $languageKey, $charset, $errorMode, $isLocalizationOverride);
		if (FALSE === $this->isWhitelisted($fileReference) || TRUE === $this->isBlacklisted($fileReference)) {
			return $data;
		}
		$proxy = LanguageFileUtility::createProxyForFile($fileReference, (array) $data);
		return [$languageKey => $proxy];
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
				if(ExtensionManagementUtility::isLoaded($whitelistedExtensionKey)) {
					$whitelistedExtensionFolder = ExtensionManagementUtility::extPath($whitelistedExtensionKey);
					if (0 === strpos($filename, $whitelistedExtensionFolder)) {
						return TRUE;
					}
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
				if(ExtensionManagementUtility::isLoaded($blacklistedExtensionKey)) {
					$blacklistedExtensionFolder = ExtensionManagementUtility::extPath($blacklistedExtensionKey);
					if (0 === strpos($filename, $blacklistedExtensionFolder)) {
						return TRUE;
					}
				}
			}
			return FALSE;
		}
		return (FALSE !== strpos($filename, '/typo3/sysext/'));
	}

}
