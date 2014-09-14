<?php
namespace FluidTYPO3\Flll\Utility;
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

use FluidTYPO3\Flll\LanguageFile\LanguageFileInterface;
use FluidTYPO3\Flll\LanguageFile\DynamicLabelAccessor;
use FluidTYPO3\Flll\Service\LanguageFileService;
use TYPO3\CMS\Core\Localization\LanguageStore;
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
