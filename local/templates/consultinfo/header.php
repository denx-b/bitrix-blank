<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();

/** @global $APPLICATION */
?>
<?
use Bitrix\Main\Localization\Loc,
    Bitrix\Main\Page\Asset;

Loc::loadMessages(__FILE__);
?>
<!DOCTYPE HTML>
<html xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
<head>
<title><?=$APPLICATION->ShowTitle()?></title>

<?if ($APPLICATION->get_cookie('G_FONTS') != '1'):?>
<script>
    var resource = document.createElement('link');
    resource.setAttribute("rel", "stylesheet");
    resource.setAttribute("href","https://fonts.googleapis.com/css?family=Open+Sans:300,400");
    var head = document.getElementsByTagName('head')[0];
    head.appendChild(resource);
</script>
<?endif;?>

<?
// При первом заходе шрифты подключаются асинхронно, при последующих в геге <link> в head
if ($APPLICATION->get_cookie('G_FONTS') == '1')
    Asset::getInstance()->addString('<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet">');
else
    $APPLICATION->set_cookie('G_FONTS', '1', time()+3600*24*3);

Asset::getInstance()->addCss(SITE_TEMPLATE_PATH .'/css/responsive.css');
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH .'/js/jquery-1.8.2.min.js');
Asset::getInstance()->addString('<link rel="icon" type="image/x-icon" href="'. SITE_TEMPLATE_PATH .'/favicon.ico"/>');
Asset::getInstance()->addString('<meta name="viewport" content="width=device-width, initial-scale=1">');
$APPLICATION->ShowHead();
?>
</head>
<body>
<div id="panel"><?$APPLICATION->ShowPanel()?></div>