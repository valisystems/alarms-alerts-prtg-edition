<?php


class JAK_cam{

	public $host;
	public $username;
	public $password;
	public $auth;

	public function __construct($config){
		$this->host = $config["host"];
		$this->username = $config["username"];
		$this->password  = $config["password"];
		$this->auth  = base64_encode($this->username . ':' . $this->password);
	}

	public function getCameras()
	{
		$url = $this->host.'/cameras';
		return $this->request($url);
	}

	public function getSingleCamImage($cam_id, $resolution = '640x480')
	{
		$url = $this->host . '/cameras/'. $cam_id.'/image' . '?keep_aspect_ratio=1&resolution='.$resolution;
        $result = $this->request($url, 'Accept: image/webp,image/*,*/*;q=0.8');
        if (! strpos($result, '404')) {
            return 'data:image/png;base64,' . base64_encode($result);
        }
		return false;
	}

	public function getSingleCamVideo($cam_id, $resolution = '640x400')
	{
		$url = $this->host . '/cameras/'. $cam_id.'/video' . '?resolution='.$resolution;
		$this->request($url);
		$auth_url = 'http://'.$this->username.':'.$this->password.'@'.str_replace('http://', '', $this->host). '/cameras/'. $cam_id.'/video' . '?keep_aspect_ratio=1&resolution='.$resolution;
		return $auth_url;
	}

	public function request($url, $accept = 'Accept: application/json')
	{
		$header = [
            "Host: " .   $this->host,
            'Origin: http://' .  $this->host,
            "User-Agent: " . $_SERVER['HTTP_USER_AGENT'],
            "Authorization: Basic ". $this->auth,
            $accept
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
            //var_dump(curl_getinfo($ch));
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