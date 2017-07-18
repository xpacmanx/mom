<?

class AmocrmApi {

  private $login = 'alexanderzaharenkov@gmail.com';
  private $password = 'c901e60505a7b2edc18f8a307397ecd1';

    public function auth() {

      $user=array(
        'USER_LOGIN'=>'alexanderzaharenkov@gmail.com', #Ваш логин (электронная почта)
        'USER_HASH'=>'c901e60505a7b2edc18f8a307397ecd1' #Хэш для доступа к API (смотрите в профиле пользователя)
      );

      #Формируем ссылку для запроса
      $link='https://stronglaser.amocrm.ru/private/api/auth.php?type=json';


      $curl=curl_init(); #Сохраняем дескриптор сеанса cURL
      #Устанавливаем необходимые опции для сеанса cURL
      curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
      curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
      curl_setopt($curl,CURLOPT_URL,$link);
      curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
      curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($user));
      curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
      curl_setopt($curl,CURLOPT_HEADER,false);
      curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
      curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
      curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
      curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);

      $out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
      $code=curl_getinfo($curl,CURLINFO_HTTP_CODE); #Получим HTTP-код ответа сервера
      curl_close($curl); #Завершаем сеанс cURL

      return $out;
    }

    public function send($method,$url,$data) {

      if (!empty($data) && $method == 'GET') {
        $url .= '?';
        $url .= http_build_query($data);
      }

      $link='https://stronglaser.amocrm.ru/private/api/v2/json'.$url;

      $curl=curl_init(); #Сохраняем дескриптор сеанса cURL
      curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
      curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
      curl_setopt($curl,CURLOPT_URL,$link);

      if ($method == 'POST') {
        $data = json_encode($data);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
      }

      curl_setopt($curl,CURLOPT_HEADER,false);
      curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
      curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
      curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
      curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);

      $out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
      $code=curl_getinfo($curl,CURLINFO_HTTP_CODE); #Получим HTTP-код ответа сервера
      curl_close($curl); #Завершаем сеанс cURL

      return $out;
    }

    public function ms_update($id, $mid, $type) {

      if ($type == 'company' || !isset($type)) {
        $url = '/company/set';
        $request['request']['contacts']['update'] = array(
          array(
            'id' => $id,
            'last_modified' => strtotime("now"),
            'custom_fields'=> array(
              array(
                'id' => '414092',
                'values'=>array(
                  array('value'=>$mid)
                )
              )
            )
          )
        );
      } elseif ($type == 'contact') {
        $url = '/contacts/set';
        $request['request']['contacts']['update'] = array(
          array(
            'id' => $id,
            'last_modified' => strtotime("now"),
            'custom_fields'=> array(
              array(
                'id' => '414092',
                'values'=>array(
                  array('value'=>$mid)
                )
              )
            )
          )
        );
      } elseif ($type == 'lead') {
        $url = '/leads/set';
        $request['request']['leads']['update'] = array(
          array(
            'id' => $id,
            'last_modified' => strtotime("now"),
            'custom_fields'=> array(
              array(
                'id' => '414068',
                'values'=>array(
                  array('value'=>$mid)
                )
              )
            )
          )
        );
      }

      $response = $this->send('POST',$url,$request);

      return $response;

    }

}
