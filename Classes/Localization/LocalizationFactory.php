<?php
namespace FluidTYPO3\Flll\Localization;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Claus Due <claus@namelesscoder.net>
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
	 * @param integer $errorMode Error mode (when file could not be found): 0 - syslog entry, 1 - do nothing, 2 - throw an exception$
	 * @param boolean $isLocalizationOverride TRUE if $fileReference is a localization override
	 * @return array|boolean
	 */
	public function getParsedData($fileReference, $languageKey, $charset, $errorMode, $isLocalizationOverride = FALSE) {
		try {
			$hash = md5($fileReference . $languageKey . $charset);
			$this->errorMode = $errorMode;
			// Check if the default language is processed before processing other language
			if (!$this->store->hasData($fileReference, 'default') && $languageKey !== 'default') {
				$this->getParsedData($fileReference, 'default', $charset, $this->errorMode);
			}
			// If the content is parsed (local cache), use it
			if ($this->store->hasData($fileReference, $languageKey)) {
				return $this->store->getData($fileReference);
			}

			// If the content is in cache (system cache), use it
			$data = $this->cacheInstance->get($hash);
			if ($data !== FALSE) {
				$this->store->setData($fileReference, $languageKey, $data);
				$proxy = LanguageFileUtility::createProxyForFile($fileReference, $languageKey, $data);
				return array($languageKey => $proxy);
			}

			$this->store->setConfiguration($fileReference, $languageKey, $charset);
			/** @var $parser \TYPO3\CMS\Core\Localization\Parser\LocalizationParserInterface */
			$parser = $this->store->getParserInstance($fileReference);
			// Get parsed data
			$LOCAL_LANG = $parser->getParsedData($this->store->getAbsoluteFileReference($fileReference), $languageKey, $charset);
			// Override localization
			if (!$isLocalizationOverride && isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride'])) {
				$this->localizationOverride($fileReference, $languageKey, $charset, $errorMode, $LOCAL_LANG);
			}
			// Save parsed data in cache
			$this->store->setData($fileReference, $languageKey, $LOCAL_LANG[$languageKey]);
			// Cache processed data
			$this->cacheInstance->set($hash, $this->store->getDataByLanguage($fileReference, $languageKey));
		} catch (\TYPO3\CMS\Core\Localization\Exception\FileNotFoundException $exception) {
			// Source localization file not found
			$this->store->setData($fileReference, $languageKey, array());
		}
		return $this->store->getData($fileReference);
	}

}
