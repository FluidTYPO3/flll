<?php
namespace FluidTYPO3\Flll\Utility;

/*
 * This file is part of the FluidTYPO3/Flll project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use FluidTYPO3\Flll\LanguageFile\DynamicLabelAccessor;
use FluidTYPO3\Flll\Service\LanguageFileService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * @package Flll
 * @subpackage Service
 */
class LanguageFileUtility {

	/**
	 * @param string $filePathAndFilename
	 * @param array $data
	 * @return DynamicLabelAccessor
	 */
	public static function createProxyForFile($filePathAndFilename, $data) {
		/** @var ObjectManagerInterface $objectManager */
		$objectManager = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
		/** @var LanguageFileService $fileService */
		$fileService = $objectManager->get('FluidTYPO3\Flll\Service\LanguageFileService');
		$fileInstance = $fileService->getLanguageFile($filePathAndFilename);
		/** @var DynamicLabelAccessor $proxy */
		$proxy = $objectManager->get('FluidTYPO3\Flll\LanguageFile\DynamicLabelAccessor');
		$proxy->setFile($fileInstance);
		$proxy->load($data);
		return $proxy;
	}

}
