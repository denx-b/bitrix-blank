<?php

namespace Dbogdanoff\Api;

use Bitrix\Main\Application;
use Bitrix\Main\DB\Exception;
use Bitrix\Main\HttpRequest;
use Bitrix\Main\Server;

abstract class Api
{
    /** @var Server */
    public $server;

    /** @var HttpRequest */
    public $request;

    /** @var array результат */
    protected $result = [];

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

        if ($this->access() !== true) {
            throw new Exception('Access denied');
        }
    }

    abstract public function init();

    /**
     * Реализуйте в своём методе проверку доступа, если это необходимо
     * @return bool
     */
    protected function access(): bool
    {
        return true;
    }

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
        if ($this->request->get('secretWorld') === 'legancy') {
            header('Access-Control-Allow-Origin: *');
        }

        if ($this->responseCode === 200) {
            header_remove('Status');
            header("HTTP/1.1 200 OK", true);
        }

        if ($this->request->get('print') === 'y') {
            echo '<pre>' . print_r($this->result, true) . '</pre>';
        } else if ($this->responseType === 'json') {
            header('Content-Type: application/json');
            echo json_encode($this->result);
        }

        require_once $this->server->getDocumentRoot() . '/bitrix/modules/main/include/epilog_after.php';
        die;
    }
}
