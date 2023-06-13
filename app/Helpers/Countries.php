<?php

namespace App\Helpers;

class Countries
{
  // Singleton
  private static $instance;
  public static function getInstance(): Countries
  {
    if(empty(self::$instance)) {
      self::$instance = new Countries();
    }

    return self::$instance;
  }
  private function __construct(){}

  private $REST_Countries = 'https://restcountries.com/v3.1/all?fields=name';

  public function getAll(): array
  {
    $data = $this->doCurlURL($this->REST_Countries);
    if(!$data)
      return array();
      
    $countries_names = array();
    foreach($data as $name)
      $countries_names[] = $name['name']['common'];
    sort($countries_names);
    return $countries_names;
  }

  public function getFlag($country): string
  {
    $country = str_replace(' ', '%20', $country);
    $get_code = "https://restcountries.com/v3.1/name/$country?fields=cca2";
    $data = $this->doCurlURL($get_code);

    $code = $data[0]['cca2'];
    $swaps = array('UM' => 'US');
    foreach($swaps as $key => $value)
      $code = str_replace($key, $value, $code);
      
    $url = "https://flagsapi.com/$code/flat/64.png";
    return $url;
  }

  private function doCurlURL($url)
  {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response, true);
    return $data;
  }
}
