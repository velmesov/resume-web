<?php

namespace app;

/**
 * Class SMS
 *
 * @package app
 */
class SMS
{
    private $curl;

    private $curlopt;

    private $postdata;

    private $response;

    /**
     * Конструктор
     */
    public function __construct()
    {
        $this->curl = curl_init();
    }

    /**
     * Выполнение запроса
     * @param  string $phone   Телефон
     * @param  string $message Сообщение
     * @return void
     */
    public function request(string $phone, string $message)
    {
        $this->setPostData([
            'phones' => $phone,
            'mes' => $message
        ]);

        $this->setCurlOpt();
        curl_setopt_array($this->curl, $this->curlopt);
        $this->sendRequest();
    }

    /**
     * Установка POST данных
     * @param array $parameters Параметры
     * @return void
     */
    private function setPostData(array $parameters)
    {
        $this->postdata = array_merge(CONF['sms']['data'], $parameters);
    }

    /**
     * Установка опций CURL
     * @return void
     */
    private function setCurlOpt()
    {
        $this->curlopt = [
            CURLOPT_URL => CONF['sms']['url'],     // url
            CURLOPT_HEADER => false,               // выводить заголовки в ответе
            CURLOPT_POST => true,                  // отправка post данных
            CURLOPT_POSTFIELDS => $this->postdata, // данные post
            CURLOPT_RETURNTRANSFER => true,        // ответ в виде строки curl_exec()
            CURLOPT_SSL_VERIFYHOST => 0,           // не проверять имена хостов
            CURLOPT_SSL_VERIFYPEER => false,       // остановка проверки сертификата
            CURLOPT_SSL_VERIFYSTATUS => false,     // проверка статуса сертификата
            CURLOPT_CONNECTTIMEOUT => 10,          // таймаут соединения
            CURLOPT_TIMEOUT => 10                  // таймаут выполнения cURL-функций
        ];
    }

    /**
     * Выполнение запроса
     * @return void
     */
    private function sendRequest()
    {
        $this->response = curl_exec($this->curl);
    }

    /**
     * Возвращаем ответ от сервера
     * @return json Ответ сервера
     */
    public function response()
    {
        return json_decode($this->response, true);
    }

    /**
     * Закрываем соединение
     */
    public function __destruct()
    {
        if (curl_errno($this->curl)) {
            var_dump(curl_error($this->curl));
        }

        curl_close($this->curl);
    }
}
