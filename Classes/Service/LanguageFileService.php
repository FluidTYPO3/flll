<?php
namespace FluidTYPO3\Flll\Service;
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

use FluidTYPO3\Flll\LanguageFile\LanguageFileInterface;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * @package Flll
 * @subpackage Service
 */
class LanguageFileService implements SingletonInterface {

	protected $objectManager;

	/**
	 * Loads file by path and returns appropriate LanguageFile
	 * implementation required by the file.
	 *
	 * Full usage example for this service as injected property:
	 *
	 *     $this->languageFileService->getLanguageFile($myFile)->add('myLabel', $value)->write();
	 *
	 * @param $filePathAndFilename
	 * @return LanguageFileInterface
	 */
	public function getLanguageFile($filePathAndFilename) {

	}

	/**
	 * Same as load($file) except is able to load the preferred
	 * language file from an extension by extension key only.
	 * Returns only preferred (currently XLF) format if multiple
	 * files exist in extension.
	 *
	 * Full usage example for this service as injected property:
	 *
	 *     $this->languageFileService->getLanguageFileByExtensionKey('myext')->add('myLabel', $value)->write();
	 *
	 * @param string $extensionKey
	 * @return LanguageFileInterface
	 */
	public function getLanguageFileByExtensionKey($extensionKey) {

	}

}
