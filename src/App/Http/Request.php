<?php 

namespace METRIC\App\Http;


class Request
{
    public $params;
    public $request_method;
    public $content_type;

    public function __construct(array $params = [], string $request_method, string $content_type)
    {
        $this->params = $params;
        $this->request_method = $request_method;
        $this->content_type = !empty($content_type) ? $content_type : "";
    }

    public function getUrlParams()
    {
        return $this->params;
    }

    /**
     * 
     * Obtener variables del body enviados por post 
     * body: "web_time=3-5-2022+10%3A46&web_device=desktop&web_browser=Google+Chrome+or+Chromium&web_language=es&web_session_time=0%3A0%3A3"
     * Headers: Content-Type: application/x-www-form-urlencoded
     * Return: array con las variables y su contenido []
     **/
    public function getBody()
    {
      if ($this->request_method !== 'POST' || $this->request_method !== 'PUT') {
          return '';
      }

      $body = [];

      // RAW application/x-www-form-urlencoded
      $body = filter_input_array(INPUT_POST);

      return $body;
    }

    /**
     * Obtener datos del body enviados por post en formato json
     * body: { "email": "eve.holt@reqres.in", "password": "pistol"}
     * Headers: Content-Type: application/json
     * Return: array con el contenido json
     **/
    public function getJSON()
    {
      if ($this->request_method !== 'POST') {
          return [];
      }

      if (!str_contains(strtolower($this->content_type), 'application/json')) {
          return [];
      }

      // RAW post data.
      $content = trim(file_get_contents("php://input"));

      return json_decode($content);
    }
}