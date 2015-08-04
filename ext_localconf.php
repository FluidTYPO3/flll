<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['flll']['setup'] = unserialize($_EXTCONF);
if (TRUE === (bool) $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['flll']['setup']['active']) {
	$whitelist = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', trim($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['flll']['setup']['whitelist']));
	if (TRUE !== empty($whitelist)) {
		$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['flll']['setup']['whitelist'] = $whitelist;
	} else {
		$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['flll']['setup']['whitelist'] = array();
	}
	$blacklist = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', trim($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['flll']['setup']['blacklist']));
	if (TRUE !== empty($blacklist)) {
		$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['flll']['setup']['blacklist'] = $blacklist;
	} else {
		$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['flll']['setup']['blacklist'] = array();
	}
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\CMS\Core\Localization\LocalizationFactory'] = array('className' => 'FluidTYPO3\Flll\Localization\LocalizationFactory');
}
