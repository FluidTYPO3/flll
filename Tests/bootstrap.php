<?php
// Register composer autoloader
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
	throw new \RuntimeException(
		'Could not find vendor/autoload.php, make sure you ran composer.'
	);
}

require_once __DIR__ . '/../vendor/autoload.php';

define('PATH_thisScript', realpath('vendor/typo3/cms/typo3/index.php'));
define('TYPO3_MODE', 'BE');
putenv('TYPO3_CONTEXT=Testing');

$nullCache = array(
	'frontend' => 'TYPO3\\CMS\\Core\\Cache\\Frontend\\VariableFrontend',
	'backend' => 'TYPO3\\CMS\\Core\\Cache\\Backend\\NullBackend'
);
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'] = array(
	'extbase_object' => $nullCache,
	'extbase_reflection' => $nullCache
);

\TYPO3\CMS\Core\Core\Bootstrap::getInstance()
	->baseSetup('typo3/')
	->initializeClassLoader()
	->initializeCachingFramework();
