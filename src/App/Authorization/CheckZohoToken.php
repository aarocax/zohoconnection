<?php 

namespace METRIC\App\Authorization;

use METRIC\App\config\AppConfig;
use METRIC\App\Service\Logger;

class CheckZohoToken
{
  
  static $logger;

  public function __construct()
  {
    self::$logger = new Logger;
  }

  private static function refreshToken()
  {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, AppConfig::getInstance()->getValue('ZOHO_TOKEN_ENDPOINT_URL'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "refresh_token=" . AppConfig::getInstance()->getValue('ZOHO_REFRESH_TOKEN') . "&client_id=" . AppConfig::getInstance()->getValue('ZOHO_CLIENT_ID') . "&client_secret=" . AppConfig::getInstance()->getValue('ZOHO_CLIENT_SECRET') . "&grant_type=refresh_token");

    $headers = array();
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    $date = new \DateTime('now');

    // añadimos fecha y hora al objeto token
    $token = json_decode($result);
    $token->time = $date->format('d-m-Y H:i:s');
    $token->timestamp = $date->getTimestamp();

    //TODO hacer un hash con el objeto token por seguridad
    file_put_contents(AppConfig::getInstance()->getValue("ZOHO_TOKEN_FILE_PATH"), json_encode($token));

    return $token->access_token;
  }

  private static function checkToken()
  {
    $file = file_get_contents(AppConfig::getInstance()->getValue("ZOHO_TOKEN_FILE_PATH"));
    $token = json_decode($file);

    if ($file == "") {
      $accessToken = self::refreshToken();
      return $accessToken;
    }
    
    $tokenDate = new \DateTime($token->time);
    $tokenDate->add(new \DateInterval('PT' . ((int)$token->expires_in - 10) . 'S')); // añado los segundos que tarda en expirar -10 por seguridad para que no se quede colgado en medio de una operación

    $nowDate = new \DateTime;

    if ($tokenDate->getTimestamp() <= $nowDate->getTimestamp()) {
      $accessToken = self::refreshToken();
    } else {
      $accessToken = $token->access_token;
    }

    return $accessToken;
  }

  public static function getToken()
  {
    $logger = new Logger;
    $logger->info("getToken...");
    return self::checkToken();
  }

}