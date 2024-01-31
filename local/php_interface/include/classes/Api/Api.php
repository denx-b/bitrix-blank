<?php

namespace Legacy\Api;

use Bitrix\Main\Application;
use Bitrix\Main\DB\Exception;
use Bitrix\Main\HttpRequest;
use Bitrix\Main\Server;
use CUser;

abstract class Api
{
    /** @var Server */
    public $server;

    /** @var HttpRequest */
    public $request;

    /** @var CUser */
    public $user;

    /** @var array результат */
    protected $result = ['success' => true];

    protected $responseType = 'json';

    protected $responseCode = 200;

    /**
     * Api constructor
     * @throws \Exception
     */
    public function __construct()
    {
        $this->server = Application::getInstance()->getContext()->getServer();
        $this->request = Application::getInstance()->getContext()->getRequest();
        $this->user = $GLOBALS['USER'];

        if ($this->access() !== true) {
            throw new Exception('Access denied');
        }
    }

    /**
     * Реализуйте в своём методе проверку доступа, если это необходимо
     * @return bool
     */
    protected function access(): bool
    {
        return true;
    }

    abstract public function init();

    /**
     * Установка сообщения об ошибки в результат
     *
     * @param string $message
     * @param int $code
     */
    public function setResultError(string $message, int $code = 0)
    {
        $this->result = ['error_message' => $message, 'error_code' => $code];
    }

    /**
     * Печать результата json или просто print_r в теге <pre>
     */
    public function result()
    {
        if ($this->responseCode === 200) {
            header_remove('Status');
            header("HTTP/1.1 200 OK", true);
        }

        if ($this->responseType === 'json') {
            header('Content-Type: application/json');
            echo json_encode($this->result);
        }

        require_once $this->server->getDocumentRoot() . '/bitrix/modules/main/include/epilog_after.php';
        die;
    }
}
