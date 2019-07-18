<?php

class JAK_alert {

    public $host;
    public $username;
    public $password;

    public function __construct($config)
    {
        $this->host = $config['host'];
        $this->username = $config['username'];
        $this->password = $config['password'];
    }

    // get list of DID - Domains - users
	// $_GET['acc'] // e.g 4444@ariole.claricomip.com
	// $_GET['dst'] // destination e.g 5555
    public function getVodiaPBXDids($account, $dest)
    {
        $userAgent = !empty($_SERVER['HTTP_USER_AGENT'])? $_SERVER['HTTP_USER_AGENT'] : "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13";

        $base_64_hash = base64_encode($this->username . ':' . $this->password);
        $url = $this->host . "/rest/hunt/" . $account . "/dial/" . $dest;
        $header = [
            "Host: " .   $this->host,
            'Origin: http://' .  $this->host,
            "User-Agent: " . $userAgent,
            "Accept: " . "*/*",
            "DNT:" . "1",
            "Authorization: Basic ". $base_64_hash
        ];
        return $this->_vodiapbx_curl_call('GET', $url, $header);
    }

    // curl calls
    public function _vodiapbx_curl_call($method, $url, $header, $params = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        //curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
        if ($method == 'POST'){
            curl_setopt($ch, CURLOPT_POST, TRUE);
        }
        if (! empty($params))
        {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);
        if(curl_errno($ch))
        {
            var_dump(curl_getinfo($ch));
            echo curl_errno($ch) . "\n";
            echo 'error:' . curl_er;
        }
        else
        {
            //var_dump(curl_getinfo($ch));
            //print_r($output);
            curl_close($ch);
            return trim($output);
        }
    }


}


?>