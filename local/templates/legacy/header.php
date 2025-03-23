<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @global $APPLICATION */

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;

Loc::loadMessages(__FILE__);

Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/script.js');

Asset::getInstance()->addString('<link rel="icon" type="image/x-icon" href="' . SITE_TEMPLATE_PATH . '/favicon.ico"/>');
Asset::getInstance()->addString('<meta name="viewport" content="width=device-width, initial-scale=1">');
?><!doctype html>
<html xml:lang="<?= LANGUAGE_ID ?>" lang="<?= LANGUAGE_ID ?>">
<head>
    <title><?= $APPLICATION->ShowTitle() ?></title>
    <?php $APPLICATION->ShowHead(); ?>
</head>
<body>
<div id="panel"><?php $APPLICATION->ShowPanel() ?></div>
