# Шаблон нового проекта 1С-Битрикс

Данный шаблон представляет из себя хороший пример структурирования файлов проекта на 1С-Битрикс.

Эффективность нашей команды сильно повысилась, когда мы внедрили автозагрузку собственных классов по **PSR-4** в битрикс проектах и стали использовать структуру и принципы описанные в данном репозитории за основу.

Ключевые договорённости в команде, которые вы можете встретить в данном репозитории:
1. Автозагрузка классов;
2. Реализации обработчиков событий вынесена из init.php;
3. Пример шаблона сайта;
4. API.

По мимом всего прочего все разработчики стилизует код в соответствии со спецификацией **PSR-12**, где это уместно, и использует данную стилизацию для автоматического форматирования в PhpStorm.

templates
-------------

Содержит шаблон сайта с эталонным примером header и footer.php, в котором использованы часто применяемые методы: работа с языковыми файлами, подключение стилей, скриптом и так далее.

```php 
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
<html xml:lang="<?php echo LANGUAGE_ID ?>" lang="<?php echo LANGUAGE_ID ?>">
<head>
    <title><?php echo $APPLICATION->ShowTitle() ?></title>
    <?php $APPLICATION->ShowHead(); ?>
</head>
<body>
<div id="panel"><?php $APPLICATION->ShowPanel() ?></div>
```

API
-------------

Используя встроенную автозагрузку классов и реализованный механизм API, можно легко добавлять свои методы:
```php
class ApiFactory implements ApiFactoryInterface
{
    public static function create(string $method = ''): Api
    {
        try {
            switch ($method) {
                case 'news':
                    $api = new Methods\News();
                    break;

                case 'newsDetail':
                    $api = new Methods\NewsDetail();
                    break;

                default:
                    $api = new Methods\Unknown();
            }

            $api->init();
```

Выше приведённый пример будет доступен по адресам:
```
/api/news
/api/newsDetail
```

Каждому методу соответствует класс из директории /local/php_interface/include/classes/Api/Methods:
```
classes
├── Agents
├── Api
│   │
│   ├── Methods
│   │   ├── News.php       <-- /api/news
│   │   ├── NewsDetail.php <-- /api/newsDetail
│   │   └── Unknown.php    <-- /api/всё_что_угодно
│   │
│   ├── Api.php
│   ├── ApiFactory.php
│   └── ApiFactoryInterface.php
│   │
├── Events
├── Model
│   └── Helper.php
│
└── eventHandlers
    ├── common.php
    └── sale.php

├── autoload.php
├── bootstrap.php
├── composer.json
└── settings.php
```
