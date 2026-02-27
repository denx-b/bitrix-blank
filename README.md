# Шаблон нового проекта 1С-Битрикс

Данный шаблон представляет из себя хороший пример структурирования файлов проекта на 1С-Битрикс.

Эффективность нашей команды сильно повысилась, когда мы внедрили автозагрузку собственных классов по **PSR-4** в битрикс проектах и стали использовать структуру и принципы описанные в данном репозитории за основу.

Ключевые договорённости в команде, которые вы можете встретить в данном репозитории:
1. Автозагрузка классов;
2. Реализации обработчиков событий вынесена из init.php;
3. Пример шаблона сайта;
4. API.

Автозагрузка классов (PSR-4)
-------------

Автозагрузка работает для **всех** классов с namespace `Legacy\*`.

Базовое правило:
`Legacy\Some\ClassName` -> `/local/php_interface/legacy/classes/Some/ClassName.php`

API
-------------

Используя встроенную автозагрузку классов и реализованный механизм API, можно легко добавлять свои методы.

Текущий поток выполнения:
1. Запросы `/api/*` направляются в `local/php_interface/legacy/api.php` через `urlrewrite`.
2. `api.php` нормализует маршрут в полный вид (`/api/...`) и передаёт его в `ApiFactory::create(...)`.
3. `ApiFactory` создаёт класс обработчика по карте маршрутов `ApiRoutes::map()`.
4. Если маршрут не найден, используется `Methods\Unknown`.

Маршруты объявляются централизованно в `ApiRoutes`:
```php
final class ApiRoutes
{
    public static function map(): array
    {
        return [
            '/api/news' => Methods\News::class,
            '/api/deploy/gitStatus' => Methods\Deploy\GitStatus::class,
            
            '/api/catalog/items' => Methods\Catalog\Items::class,
            '/api/catalog/itemDetail' => Methods\Catalog\ItemDetail::class,
            
            '/api/order/create' => Methods\Order\Create::class,
            '/api/order/cancel' => Methods\Order\Cancel::class,
            
            '/api/profile/updatePhone' => Methods\Profile\UpdatePhone::class,
        ];
    }
}
```

Каждому методу соответствует класс из директории `/local/php_interface/legacy/classes/Api/Methods`:

Регистрация обработчиков событий
-------------

В проекте автоматически подключаются все PHP-файлы из директорий:
- `local/php_interface/legacy/functions`
- `local/php_interface/legacy/eventHandlers`

Для регистрации обработчиков в команде принято держать файлы в `eventHandlers` с именем модуля:
- `iblock.php` для событий модуля `iblock`
- `main.php` для событий модуля `main`
- `crm.php` для событий модуля `crm`
- и т.д.

Это соглашение для удобства навигации, а не жёсткое ограничение: файл может называться иначе, и таких файлов может быть сколько угодно.

templates
-------------

Друзья, пожалуйста, не пишите addCss и addJs в теге `<head>`, так как место вызова метода не является местом подключения скриптов или стилей.
Все ваши подключения будут выведены в месте вызова `$APPLICATION->ShowHead();`, который мы аккуратно выносим в `<head>`.
А весь PHP в `header.php` размещаем перед HTML-содержимым шаблона, как показано в примере ниже.

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

Структура
-------------
```
local/php_interface/legacy
├── classes
│   ├── Agents
│   ├── Api
│   │   ├── Methods
│   │   │   ├── News.php              <-- /api/news
│   │   │   ├── Deploy/GitStatus.php  <-- /api/deploy/gitStatus
│   │   │   └── Unknown.php           <-- /api/всё_что_угодно
│   │   │
│   │   ├── Api.php
│   │   ├── ApiFactory.php
│   │   └── ApiRoutes.php
│   │
│   ├── Events
│   │   ├── CommonHandlers.php
│   │   ├── IblockHandlers.php
│   │   └── SaleHandlers.php
│   │
│   └── Model
│       └── MyTable.php
│
├── functions
│   └── custom_mail.php
│
├── eventHandlers
│   ├── common.php
│   ├── iblock.php
│   └── sale.php
│
├── autoload.php
├── bootstrap.php
├── composer.json
└── settings.php
```
