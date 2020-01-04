<?php

namespace Dbogdanoff\Events;

use Dbogdanoff\Helper;
use Exception;

class Subscribe
{
    /** @var string соль для генерации хеша */
    const SALT = 'salt_here';

    /**
     * Подмена переменных в теле письма перед отправкой выпуска рассылки
     *
     * @param $arFields
     * @return mixed
     * @throws Exception
     */
    public static function beforePostingSendMailHandler($arFields)
    {
        $serverName = php_sapi_name() == 'cli' ? 'https://' . SITE_SERVER_NAME : Helper::getServerName();
        $unSubLink = $serverName . '/subscribe/unsubscribe.php?' . http_build_query([
                'hash' => self::getHash($arFields['EMAIL']),
                'email' => $arFields['EMAIL']
            ]);

        $arFields['BODY'] = str_replace('#UNSUB#', $unSubLink, $arFields['BODY']);
        return $arFields;
    }

    /**
     * Генерирует хеш для идентификации пользвоателя с письма
     *
     * @param string $email
     * @return string
     */
    public static function getHash(string $email): string
    {
        return md5($email . self::SALT);
    }
}
