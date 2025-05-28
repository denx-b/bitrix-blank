<?php

namespace Legacy\Api;

use Bitrix\Main\Application;
use Bitrix\Main\HttpRequest;
use Bitrix\Main\Server;
use CUser;
use Exception;

abstract class Api
{
    /** @var Server */
    public Server $server;

    /** @var HttpRequest */
    public HttpRequest $request;

    /** @var CUser */
    public CUser $user;

    /** @var array результат */
    private array $result = ['success' => true, 'errorMessage' => '', 'successMessage' => ''];

    protected string $responseType = 'json';

    public function __construct()
    {
        $this->server = Application::getInstance()->getContext()->getServer();
        $this->request = Application::getInstance()->getContext()->getRequest();
        $this->user = $GLOBALS['USER'];
    }

    /**
     * @throws Exception
     */
    abstract function init();

    protected function setField(string $name, $value, $key = false)
    {
        if (strlen($key) > 0) {
            $this->result[$name][$key] = $value;
        } elseif ($key === null) {
            $this->result[$name][] = $value;
        } else {
            $this->result[$name] = $value;
        }
    }

    protected function setFields(array $fields)
    {
        $this->result = array_merge($this->result, $fields);
    }

    protected function setSuccessMessage(string $message)
    {
        $this->setField('successMessage', $message);
    }

    /**
     * Установка сообщения об ошибки в результат
     *
     * @param string $message
     * @param int $code
     */
    public function setResultError(string $message, int $code = 200)
    {
        $this->setFields(['success' => false, 'errorMessage' => $message]);
        header_remove('Status');
        http_response_code($code ?: 200);
    }

    /**
     * Вывод результата json
     */
    public function result()
    {
        if ($this->responseType === 'json') {
            header('Content-Type: application/json');
            echo json_encode($this->result);
        }

        require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php';
        die;
    }
}
