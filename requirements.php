<?php
/**
 * Application requirement checker script.
 *
 * In order to run this script use the following console command:
 * php requirements.php
 *
 * In order to run this script from the web, you should copy it to the web root.
 * If you are using Linux you can create a hard link instead, using the following command:
 * ln ../requirements.php requirements.php
 */

// you may need to adjust this path to the correct Yii framework path
$frameworkPath = dirname(__FILE__) . '/vendor/yiisoft/yii2';

if (!is_dir($frameworkPath)) {
    echo '<h1>Error</h1>';
    echo '<p><strong>The path to yii framework seems to be incorrect.</strong></p>';
    echo '<p>You need to install Yii framework via composer or adjust the framework path in file <abbr title="' . __FILE__ . '">' . basename(__FILE__) . '</abbr>.</p>';
    echo '<p>Please refer to the <abbr title="' . dirname(__FILE__) . '/README.md">README</abbr> on how to install Yii.</p>';
}

require_once $frameworkPath . '/requirements/YiiRequirementChecker.php';
$requirementsChecker = new YiiRequirementChecker();

$gdMemo = $imagickMemo = 'Either GD PHP extension with FreeType support or ImageMagick PHP extension with PNG support is required for image CAPTCHA.';
$gdOK = $imagickOK = false;

if (extension_loaded('imagick')) {
    $imagick = new Imagick();
    $imagickFormats = $imagick->queryFormats('PNG');
    if (in_array('PNG', $imagickFormats)) {
        $imagickOK = true;
    } else {
        $imagickMemo = 'Imagick extension should be installed with PNG support in order to be used for image CAPTCHA.';
    }
}

if (extension_loaded('gd')) {
    $gdInfo = gd_info();
    if (!empty($gdInfo['FreeType Support'])) {
        $gdOK = true;
    } else {
        $gdMemo = 'GD extension should be installed with FreeType support in order to be used for image CAPTCHA.';
    }
}

/**
 * Adjust requirements according to your application specifics.
 */
$requirements = array(
    // Database :
    array(
        'name' => 'PDO extension',
        'mandatory' => true,
        'condition' => extension_loaded('pdo'),
        'by' => 'All DB-related classes',
    ),
    array(
        'name' => 'PDO SQLite extension',
        'mandatory' => false,
        'condition' => extension_loaded('pdo_sqlite'),
        'by' => 'All DB-related classes',
        'memo' => 'Required for SQLite database.',
    ),
    array(
        'name' => 'PDO MySQL extension',
        'mandatory' => false,
        'condition' => extension_loaded('pdo_mysql'),
        'by' => 'All DB-related classes',
        'memo' => 'Required for MySQL database.',
    ),
    array(
        'name' => 'PDO PostgreSQL extension',
// @chris68
        'mandatory' => true,
        'condition' => extension_loaded('pdo_pgsql'),
        'by' => 'All DB-related classes',
        'memo' => 'Required for PostgreSQL database.',
    ),
    // Cache :
    array(
        'name' => 'Memcache extension',
        'mandatory' => false,
        'condition' => extension_loaded('memcache') || extension_loaded('memcached'),
        'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-caching-memcache.html">MemCache</a>',
        'memo' => extension_loaded('memcached') ? 'To use memcached set <a href="http://www.yiiframework.com/doc-2.0/yii-caching-memcache.html#$useMemcached-detail">MemCache::useMemcached</a> to <code>true</code>.' : ''
    ),
    array(
        'name' => 'APC extension',
        'mandatory' => false,
        'condition' => extension_loaded('apc'),
        'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-caching-apccache.html">ApcCache</a>',
    ),
    // CAPTCHA:
    array(
        'name' => 'GD PHP extension with FreeType support',
        'mandatory' => false,
        'condition' => $gdOK,
        'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-captcha-captcha.html">Captcha</a>',
        'memo' => $gdMemo,
    ),
    array(
        'name' => 'ImageMagick PHP extension with PNG support',
        'mandatory' => false,
        'condition' => $imagickOK,
        'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-captcha-captcha.html">Captcha</a>',
        'memo' => $imagickMemo,
    ),
    // PHP ini :
    'phpExposePhp' => array(
        'name' => 'Expose PHP',
        'mandatory' => false,
        'condition' => $requirementsChecker->checkPhpIniOff("expose_php"),
        'by' => 'Security reasons',
        'memo' => '"expose_php" should be disabled at php.ini',
    ),
    'phpAllowUrlInclude' => array(
        'name' => 'PHP allow url include',
        'mandatory' => false,
        'condition' => $requirementsChecker->checkPhpIniOff("allow_url_include"),
        'by' => 'Security reasons',
        'memo' => '"allow_url_include" should be disabled at php.ini',
    ),
    'phpSmtp' => array(
        'name' => 'PHP mail SMTP',
        'mandatory' => false,
        'condition' => strlen(ini_get('SMTP'))>0,
        'by' => 'Email sending',
        'memo' => 'PHP mail SMTP server required',
    ),
// @chris68
    // Pnauw specific
    array(
        'name' => 'GD extension',
        'mandatory' => true,
        'condition' => (extension_loaded('gd')),
        'by' => 'QR Codes',
        'memo' => 'Install via sudo apt-get install php-gd',
    ),
    array(
        'name' => 'Imagick extension',
        'mandatory' => true,
        'condition' => (extension_loaded('imagick')),
        'by' => 'Pictures',
        'memo' => 'Install via sudo apt-get install php-imagick',
    ),
    'phpFileUploadAllowed' => array(
        'name' => 'PHP file upload allowed',
        'mandatory' => true,
        'condition' => $requirementsChecker->checkPhpIniOn('file_uploads'),
        'by' => 'Uploading pictures',
        'memo' => 'File uploads must be allowed',
    ),
    'phpFileUploadSize' => array(
        'name' => 'PHP file upload size',
        'mandatory' => true,
        'condition' => $requirementsChecker->compareByteSize(ini_get('upload_max_filesize'),'10mb','>='),
        'by' => 'Uploading pictures',
        'memo' => 'Maximum allowed filesize (upload_max_filesize) must be at least 10M; current value:'.ini_get('upload_max_filesize'),
    ),
    'phpFileUploadNumber' => array(
        'name' => 'PHP file upload number',
        'mandatory' => true,
        'condition' => ini_get('max_file_uploads') >= 50,
        'by' => 'Uploading pictures',
        'memo' => 'Maximum allowed number of file upload (max_file_uploads) must be at least 50; current value:'.ini_get('max_file_uploads'),
    ),
    'phpFileUploadPostSize' => array(
        'name' => 'Post size',
        'mandatory' => true,
        'condition' => $requirementsChecker->getByteSize(ini_get('post_max_size')) >= 50 * $requirementsChecker->getByteSize('1mb')+$requirementsChecker->getByteSize('5mb'),
        'by' => 'Uploading pictures',
        'memo' => 'Maximum postsize (post_max_size) must fit to the file upload requirements (i.e. max files * max size + buffer); current value:'.ini_get('post_max_size'),
    ),
    'phpFileUploadMemoryLimit' => array(
        'name' => 'Memory limit',
        'mandatory' => true,
        'condition' => ini_get('memory_limit') == -1 || $requirementsChecker->getByteSize(ini_get('memory_limit')) > 50 * $requirementsChecker->getByteSize('1mb')+$requirementsChecker->getByteSize('10mb'),
        'by' => 'Uploading pictures',
        'memo' => 'Memory limit (memory_limit) must fit to the file upload requirements (i.e. max files * max size + buffer); current value:'.ini_get('memory_limit'),
    ),
);
$requirementsChecker->checkYii()->check($requirements)->render();
