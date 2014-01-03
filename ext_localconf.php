<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['flll']['setup'] = unserialize($_EXTCONF);
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['flll']['setup']['whitelist'] =
	0 < strlen(trim($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['flll']['setup']['whitelist'])) ?
	\TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', trim($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['flll']['setup']['whitelist'])) :
	array();
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['flll']['setup']['blacklist'] =
	0 < strlen(trim($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['flll']['setup']['blacklist'])) ?
	\TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', trim($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['flll']['setup']['blacklist'])) :
	array();
$GLOBALS['TYPO3_CONF_VARS']['SYS']['lang']['parser']['xlf'] = 'FluidTYPO3\Flll\LanguageFile\XliffParser';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['lang']['parser']['xml'] = 'FluidTYPO3\Flll\LanguageFile\XmlParser';
