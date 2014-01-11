<?php
/**
 * Application requirement checker script.
 *
 * In order to run this script use the following console command:
 * php requirements.php
 *
 * In order to run this script from the web, you should copy it to the web root.
 * If you are using Linux you can create a hard link instead, using the following command:
 * ln ../../requirements.php requirements.php 
 */

// you may need to adjust this path to the correct Yii framework path
$frameworkPath = dirname(__FILE__) . '/vendor/yiisoft/yii2';
if (!is_dir($frameworkPath)) {
	// situation where the script is called from within the web root; so fix it to support both locations
	$frameworkPath = dirname(__FILE__) . '/../../vendor/yiisoft/yii2';
}

if (!is_dir($frameworkPath)) {
	echo '<h1>Error</h1>';
	echo '<p><strong>The path to yii framework seems to be incorrect.</strong></p>';
	echo '<p>You need to install Yii framework via composer or adjust the framework path in file <abbr title="' . __FILE__ . '">' . basename(__FILE__) .'</abbr>.</p>';
	echo '<p>Please refer to the <abbr title="' . dirname(__FILE__) . '/README.md">README</abbr> on how to install Yii.</p>';
}

require_once($frameworkPath . '/requirements/YiiRequirementChecker.php');
$requirementsChecker = new YiiRequirementChecker();

/**
 * Adjust requirements according to your application specifics.
 */
$requirements = [
	// Database :
	[
		'name' => 'PDO extension',
		'mandatory' => true,
		'condition' => extension_loaded('pdo'),
		'by' => 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>',
	],
	[
		'name' => 'PDO PostgreSQL extension',
		'mandatory' => true,
		'condition' => extension_loaded('pdo_pgsql'),
		'by' => 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>',
		'memo' => 'Required for PostgreSQL database.',
	],
	// Cache :
	[
		'name' => 'Memcache extension',
		'mandatory' => false,
		'condition' => extension_loaded('memcache') || extension_loaded('memcached'),
		'by' => '<a href="http://www.yiiframework.com/doc/api/CMemCache">CMemCache</a>',
		'memo' => extension_loaded('memcached') ? 'To use memcached set <a href="http://www.yiiframework.com/doc/api/CMemCache#useMemcached-detail">CMemCache::useMemcached</a> to <code>true</code>.' : ''
	],
	[
		'name' => 'APC extension',
		'mandatory' => false,
		'condition' => extension_loaded('apc'),
		'by' => '<a href="http://www.yiiframework.com/doc/api/CApcCache">CApcCache</a>',
	],
	// Additional PHP extensions :
	[
		'name' => 'Mcrypt extension',
		'mandatory' => false,
		'condition' => extension_loaded('mcrypt'),
		'by' => '<a href="http://www.yiiframework.com/doc/api/CSecurityManager">CSecurityManager</a>',
		'memo' => 'Required by encrypt and decrypt methods.'
	],
	// PHP ini :
	'phpSafeMode' => [
		'name' => 'PHP safe mode',
		'mandatory' => false,
		'condition' => $requirementsChecker->checkPhpIniOff("safe_mode"),
		'by' => 'File uploading and console command execution',
		'memo' => '"safe_mode" should be disabled at php.ini',
	],
	'phpExposePhp' => [
		'name' => 'Expose PHP',
		'mandatory' => false,
		'condition' => $requirementsChecker->checkPhpIniOff("expose_php"),
		'by' => 'Security reasons',
		'memo' => '"expose_php" should be disabled at php.ini',
	],
	'phpAllowUrlInclude' => [
		'name' => 'PHP allow url include',
		'mandatory' => false,
		'condition' => $requirementsChecker->checkPhpIniOff("allow_url_include"),
		'by' => 'Security reasons',
		'memo' => '"allow_url_include" should be disabled at php.ini',
	],
	'phpSmtp' => [
		'name' => 'PHP mail SMTP',
		'mandatory' => false,
		'condition' => strlen(ini_get('SMTP'))>0,
		'by' => 'Email sending',
		'memo' => 'PHP mail SMTP server required',
	],
	// Pnauw specific
	'phpFileUploadAllowed' => [
		'name' => 'PHP file upload allowed',
		'mandatory' => true,
		'condition' => $requirementsChecker->checkPhpIniOn('file_uploads'),
		'by' => 'Uploading pictures',
		'memo' => 'File uploads must be allowed',
	],
	'phpFileUploadSize' => [
		'name' => 'PHP file upload size',
		'mandatory' => true,
		'condition' => $requirementsChecker->compareByteSize(ini_get('upload_max_filesize'),'1mb','>='),
		'by' => 'Uploading pictures',
		'memo' => 'Maximum allowed filesize (upload_max_filesize) must be at least 1M; current value:'.ini_get('upload_max_filesize'),
	],
	'phpFileUploadNumber' => [
		'name' => 'PHP file upload number',
		'mandatory' => true,
		'condition' => ini_get('max_file_uploads') >= 50,
		'by' => 'Uploading pictures',
		'memo' => 'Maximum allowed number of file upload (max_file_uploads) must be at least 50; current value:'.ini_get('max_file_uploads'),
	],
	'phpFileUploadPostSize' => [
		'name' => 'Post size',
		'mandatory' => true,
		'condition' => $requirementsChecker->getByteSize(ini_get('post_max_size')) >= 50 * $requirementsChecker->getByteSize('1mb')+$requirementsChecker->getByteSize('5mb'),
		'by' => 'Uploading pictures',
		'memo' => 'Maximum postsize (post_max_size) must fit to the file upload requirements (i.e. max files * max size + buffer); current value:'.ini_get('post_max_size'),
	],
	'phpFileUploadMemoryLimit' => [
		'name' => 'Memory limit',
		'mandatory' => true,
		'condition' => ini_get('memory_limit') == -1 || $requirementsChecker->getByteSize(ini_get('memory_limit')) > 50 * $requirementsChecker->getByteSize('1mb')+$requirementsChecker->getByteSize('10mb'),
		'by' => 'Uploading pictures',
		'memo' => 'Memory limit (memory_limit) must fit to the file upload requirements (i.e. max files * max size + buffer); current value:'.ini_get('memory_limit'),
	],
];
$requirementsChecker->checkYii()->check($requirements)->render();

