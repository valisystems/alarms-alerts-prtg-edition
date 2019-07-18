<?php

require 'class.net.php';

class Vodia
{
	private $destUrl = "";
    private $loginName = "";
    private $loginPass = "";
    private $sessId = "";

    public function __construct(array $config = null)
    {
    	if (!empty($config))
    	{
            $port = !empty($config["analytic_pbxport"]) ? ":".$config["analytic_pbxport"] : "";
    		$this->destUrl = $config["analytic_pbxhost"].$port;
		    $this->loginName = $config["analytic_pbxusername"];
		    $this->loginPass = $config["analytic_pbxpassword"];
		    $this->login();
    	}
    	else
    	{
		    //$this->sessId = "";
    	}
    }

    public function setSession($sess){
        $this->sessId = $sess;
    }
    public function getSession(){
        return $this->sessId;
    }

    public function login() {
        $args = json_encode(array("name" => "auth", "value" => $this->loginName . " " . md5($this->loginPass)));
        $url = "http://" . $this->destUrl . "/rest/system/session";
        $this->sessId = str_replace('"', '', $this->curlHttpRequest('PUT', $url, $args));
        return $this->sessId;
    }

    // return "ok"
    public function postDomain($s){
        $url = "http://" . $this->destUrl . "/rest/system/domains";
        return $this->curlHttpRequest('POST', $url, json_encode($s));
    }

    public function putDomainConfig($domain, $s){
        $url = $this->destUrl . "/rest/domain/" . $domain . "/config";
        return $this->curlHttpRequest('PUT', $url, json_encode($s));
    }

    public function getDomainInfo() {
        $url = "http://" . $this->destUrl . "/rest/system/domaininfo";
        return $this->curlHttpRequest('GET', $url);
    }
    
    public function getDomains() {
    	$url = "http://" . $this->destUrl . "/rest/system/domains";
        return $this->curlHttpRequest('GET', $url);
    }
    
    public function getDomainSettings($domain) {
        $url = "http://" . $this->destUrl . "/rest/domain/" . $domain . "/settings";
        return $this->curlHttpRequest('GET', $url);
    }

    public function putDomainSettings($domain, $s) {
        $url = "http://" . $this->destUrl . "/rest/domain/" . $domain . "/settings/";
        return $this->curlHttpRequest('PUT', $url, json_encode($s));
    }

    // return true
    public function deleteDomain($domain) {
        $url = "http://" . $this->destUrl . "/rest/system/domains/" . $domain;
        $this->curlHttpRequest('DELETE', $url, $set);
    }
    
    public function getUserList($domain, $type) {
        $url = "http://" . $this->destUrl . "/rest/domain/" . $domain . "/userlist/" . $type;
        return $this->curlHttpRequest('GET', $url);
    }
    
    public function getUserSettings($domain, $account) {
        $url = "http://" . $this->destUrl . "/rest/domain/" . $domain . "/user_settings/" . $account;
        return $this->curlHttpRequest('GET', $url);
    }
    
    public function putUserSettings($domain, $account, $s) {
        $set = json_encode($s);
        $url = "http://" . $this->destUrl . "/rest/domain/" . $domain . "/user_settings/" . $account;
        return $this->curlHttpRequest('PUT', $url, $set);
    }
    
    public function createAccount($domain, $s) {
        $set = json_encode($s);
        $url = "http://" . $this->destUrl . "/rest/domain/" . $domain . "/addacc/";
        return $this->curlHttpRequest('PUT', $url, $set);
    }
    
    public function domainAction($domain, $s) {
        $set = json_encode($s);
        $url = "http://" . $this->destUrl . "/rest/domain/" . $domain . "/domain_action/";
        return $this->curlHttpRequest('PUT', $url, $set);
    }
    
    public function getCallHistory($num='50')
    {
        $url = "http://" . $this->destUrl . "/rest/system/cdr/0-" . $num;
        return $this->curlHttpRequest('GET', $url);
    }

    // IF you login as User and have user session token
    // User /extension portal
    // Voicemail messages
    public function getVoiceMessages(){
        $url = "http://" . $this->destUrl . "/rest/user/self/messages";
        return $this->curlHttpRequest('GET', $url);
    }

    
    public function getDomainTrunks($domain) {
        $url = "http://" . $this->destUrl . "/rest/domain/" . $domain . "/domain_trunks/";
        return $this->curlHttpRequest('GET', $url);
    }
    
    public function createTrunk($domain, $s) {
        $set = json_encode($s);
        $url = "http://" . $this->destUrl . "/rest/domain/" . $domain . "/domain_trunks/";
        return $this->curlHttpRequest('PUT', $url, $set);
    }
    
    public function setTrunkSettings($domain, $trunk, $s) {
        $set = json_encode($s);
        $url = "http://" . $this->destUrl . "/rest/domain/" . $domain . "/edit_trunk/" . $trunk;
        return $this->curlHttpRequest('PUT', $url, $set);
    }
    
    public function getTrunkSettings($domain, $trunk) {
        $url = "http://" . $this->destUrl . "/rest/domain/" . $domain . "/edit_trunk/" . $trunk;
        return $this->curlHttpRequest('GET', $url);
    }
    
    public function getDialplans($domain) {
        $url = "http://" . $this->destUrl . "/rest/domain/" . $domain . "/dialplans/";
        return $this->curlHttpRequest('GET', $url);
    }
    
    public function createDialplan($domain, $s) {
        $set = json_encode($s);
        $url = "http://" . $this->destUrl . "/rest/domain/" . $domain . "/dialplans/";
        return $this->curlHttpRequest('PUT', $url, $set);
    }
    
    public function setDialplanSettings($domain, $dp, $s) {
        $set = json_encode($s);
        $url = "http://" . $this->destUrl . "/rest/domain/" . $domain . "/edit_dialplan/" . $dp;
        return $this->curlHttpRequest('PUT', $url, $set);
    }
    
    public function getDialplanSettings($domain, $dp) {
        $url = "http://" . $this->destUrl . "/rest/domain/" . $domain . "/edit_dialplan/" . $dp;
        return $this->curlHttpRequest('GET', $url);
    }
    
    public function getAdrbook($domain) {
        $url = "http://" . $this->destUrl . "/rest/domain/" . $domain . "/adrbook/";
        return $this->curlHttpRequest('GET', $url);
    }
    
    public function createAdr($domain, $s) {
        $set = json_encode($s);
        $url = "http://" . $this->destUrl . "/rest/domain/" . $domain . "/adrbook/";
        return $this->curlHttpRequest('PUT', $url, $set);
    }
    
    public function setAdr($domain, $adr, $s) {
        $set = json_encode($s);
        $url = "http://" . $this->destUrl . "/rest/domain/" . $domain . "/edit_adrbook/" . $adr;
        return $this->curlHttpRequest('PUT', $url, $set);
    }
    
    public function getAdr($domain, $adr) {
        $url = "http://" . $this->destUrl . "/rest/domain/" . $domain . "/edit_adrbook/" . $adr;
        return $this->curlHttpRequest('GET', $url);
    }
    
    public function getWebLangList($domain) {
        $url = "http://" . $this->destUrl . "/rest/domain/" . $domain . "/account/" . "40" . "/list" . "/list_languages";
        return $this->curlHttpRequest('GET', $url);
    }

    public function getDids(){
        $url = "http://" . $this->destUrl . "/rest/system/did";
        return $this->curlHttpRequest('GET', $url);
    }

    public function setDid($s){
        // set format
        /*$s = [
            'cmd' => 'add',
            'did' => $putData['did'],
            'dom' => $putData['domain_id'],
            'user' => $putData['user_id']
            //'out' => false
        ];
        */
        // delete format
        /*  $data = [
            'cmd' => 'delete',
            'did' => $delete_did
            //'out' => false
        ];
      */
        $set = json_encode($s);
        $url = "http://" . $this->destUrl . "/rest/system/did";
        return $this->curlHttpRequest('PUT', $url, $set);
    }

    public function getWallboard($domain, $ext, $acd)
    {
        $url = "http://" . $this->destUrl . "/rest/user/" . $ext . "@" . $domain . "/wallboard/" . $acd;
        return $this->curlHttpRequest('GET', $url);
    }


	private function curlHttpRequest($method, $url, $data=null, $authorization=null)
	{
        $userAgent = !empty($_SERVER['HTTP_USER_AGENT'])? $_SERVER['HTTP_USER_AGENT'] : "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13";

		$netHttp = new Http();
		$netHttp->setHeaders(array_filter([
			"Host: " . $this->destUrl,
			"Connection: keep-alive",
			"Origin: http://" . $this->destUrl,
			"User-Agent: " . $userAgent,
			"Accept: */* ",
			"DNT: 1",
            (!empty($this->sessId)) ? "Cookie: session=" . $this->sessId : '',
            (!empty($data)) ? "Content-Length: " . strlen($data) : '',
			(!empty($authorization)) ? "Authorization: Basic " . base64_encode($authorization) : ''
		]));


        if (empty($data))
        {
            return $netHttp->request($method, $url);
        }
        else
        {
            return $netHttp->request($method, $url, $data);
        }
    }

}