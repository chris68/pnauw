<?php
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');

// Our website is all utf-8; so we better make sure the default mb_internal_encoding is utf-8 as well; otherwise routines like mb_strtolower won't work correctly
mb_internal_encoding('UTF-8');
