<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @global $APPLICATION */

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;

Loc::loadMessages(__FILE__);

Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/css/responsive.css');
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/jquery-1.8.2.min.js');

Asset::getInstance()->addString('<link rel="icon" type="image/x-icon" href="' . SITE_TEMPLATE_PATH . '/favicon.ico"/>');
Asset::getInstance()->addString('<meta name="viewport" content="width=device-width, initial-scale=1">');
?>

<!doctype html>
<html xml:lang="<?php echo LANGUAGE_ID ?>" lang="<?php echo LANGUAGE_ID ?>">
<head>
    <title><?php echo $APPLICATION->ShowTitle() ?></title>
    <?php $APPLICATION->ShowHead(); ?>
</head>
<body>
<div id="panel"><?php $APPLICATION->ShowPanel() ?></div>
