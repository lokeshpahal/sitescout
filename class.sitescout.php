<?php

/**
* Basic interaction with the SiteScout API.
* Includes authentication functionality.
*
* Written from scratch to provide a light weight solution to fetch stats regarding capmaings 
*
*/


class API{
  
  private $_auth_url = null;
  private $_client_id = null;
  private $_client_secret = null;
  private $_token = null;
  private $_auth_header = null;
  private $_user_agent = 'Cloud API PHP wrapper';
  private $_ch_header = null;
  private $_ch_time_out = 60;
  private $_ch_post = null;
  private $_ch = null;
  private $_advertiser_id= null;
  
  /**
    * set api credentials ,auth header and initialize CURL to make request
    * @var client_id, client_secret
  */
  public function __construct($client_id = null, $client_secret = null) {
    $this->_client_id =$client_id;
    $this->_client_secret =$client_secret;
    $this->setAuthHeader();
    $this->_ch_header = $this->setCurlHeader();
  }
  
  public function init(){
    $this->_ch = curl_init();
  }
  
  /**
    * set api request URL
    * @var url
  */
  public function setApiUrl($url=null){
    $this->_auth_url =$url;
  }
  
  /**
    * set post query
    * @var post
  */
  public function setPostFields($post=null){
    $this->_ch_post = $post;
  }
  
  /**
    * set auth header
    * @var header
  */
  public function setAuthHeader($header=null){
    if($header==null){
      $Authorization_header = base64_encode($this->_client_id.':'.$this->_client_secret);
      $this->_auth_header = "Basic {$Authorization_header}";
    }else{
      $this->_auth_header = "{$header}";
    }
  }
  
  /**
    * set CURL header
    * @var 
  */
  public function setCurlHeader(){
    $header  = array(
      "POST /oauth/token HTTP/1.1",
      "HOST: api.sitescout.com",
      "Authorization: {$this->_auth_header}",
      "Content-Type: application/x-www-form-urlencoded",
      "Accept: application/json",
      "Content-Length: 41"
    );
    return $header;
  }

  public function __destruct() {
    
  }

  public function setUserAgent($agent) {
      $this->_user_agent = $agent;
  }

  public function getUserAgent() {
      return $this->_user_agent;
  }
  
  public function setCurlTimeout($time=null){
    if($time!=null){
      $this->_ch_time_out($time);
    }
  }
  
  /**
    * set Advertizer ID
    * @var id
  */
  public function setAdvertiserId($id=null){
    if($id!=null){
      $this->_advertiser_id = $id;
    }
  }
  
  /**
    * get Advertizer id
    * @var 
  */
  public function getAdvertiserId(){
    return $this->_advertiser_id;
  }

  /**
    * set auth token
    * @var tkn
  */
  public function setToken($tkn=null){
    if($tkn!=null){
      $this->_token = $tkn;
    }
  }
  
  /**
    * get auth token
    * @var url
  */
  public function getToken(){
    return $this->_token;
  }


  public function execute() {
  	$this->init();
    curl_setopt($this->_ch, CURLOPT_URL, $this->_auth_url);
    curl_setopt($this->_ch, CURLOPT_HEADER, true);
    curl_setopt($this->_ch, CURLOPT_HTTPHEADER, $this->_ch_header);
    curl_setopt($this->_ch, CURLOPT_TIMEOUT, $this->_ch_time_out);
    curl_setopt($this->_ch, CURLOPT_POST, true);
    curl_setopt($this->_ch, CURLOPT_POSTFIELDS, $this->_ch_post);
    curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($this->_ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($this->_ch);
    curl_close($this->_ch);
    return $response;
  }
  
  /**
    * fetch advertizer campaigns
    * @var url
  */
  public function getCampaigns($query=''){
  $this->init();
    $curl = 'https://api.sitescout.com/advertisers/'.$this->_advertiser_id.'/campaigns/stats?'.$query;
     $cheader  = array(
      "HOST: api.sitescout.com",
      "Authorization: Bearer {$this->_token}",
      "Content-Type: application/x-www-form-urlencoded",
      "Accept: application/json"
    );
    curl_setopt($this->_ch, CURLOPT_URL, $curl);
    curl_setopt($this->_ch, CURLOPT_HEADER, true);
    curl_setopt($this->_ch, CURLOPT_HTTPHEADER, $cheader);
    curl_setopt($this->_ch, CURLOPT_TIMEOUT, $this->_ch_time_out);
    curl_setopt($this->_ch, CURLOPT_HTTPGET, 1);
    curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($this->_ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($this->_ch);
     curl_close($this->_ch);
    return $response;
  }
  
  /**
    * fetch advertizer specific campaign 
    * @var cid
  */
  public function getCampaign($cid=null,$query=''){
  $this->init();
    $curl = 'https://api.sitescout.com/advertisers/'.$this->_advertiser_id.'/campaigns/'.$cid.'/stats?'.$query;
     $cheader  = array(
      "HOST: api.sitescout.com",
      "Authorization: Bearer {$this->_token}",
      "Content-Type: application/x-www-form-urlencoded",
      "Accept: application/json"
    );
    curl_setopt($this->_ch, CURLOPT_URL, $curl);
    curl_setopt($this->_ch, CURLOPT_HEADER, true);
    curl_setopt($this->_ch, CURLOPT_HTTPHEADER, $cheader);
    curl_setopt($this->_ch, CURLOPT_TIMEOUT, $this->_ch_time_out);
    curl_setopt($this->_ch, CURLOPT_HTTPGET, 1);
    curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($this->_ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($this->_ch);
     curl_close($this->_ch);
    return $response;
  }
  
  
  /**
    * fetch advertizer site stats
    * @var cid, siteRef
  */
  public function getCampaignPerSite($cid=null,$query=''){
  $this->init();
    $curl = 'https://api.sitescout.com/advertisers/'.$this->_advertiser_id.'/campaigns/'.$cid.'/stats/sites?'.$query;
     $cheader  = array(
      "HOST: api.sitescout.com",
      "Authorization: Bearer {$this->_token}",
      "Content-Type: application/x-www-form-urlencoded",
      "Accept: application/json"
    );
    curl_setopt($this->_ch, CURLOPT_URL, $curl);
    curl_setopt($this->_ch, CURLOPT_HEADER, true);
    curl_setopt($this->_ch, CURLOPT_HTTPHEADER, $cheader);
    curl_setopt($this->_ch, CURLOPT_TIMEOUT, $this->_ch_time_out);
    curl_setopt($this->_ch, CURLOPT_HTTPGET, 1);
    curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($this->_ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($this->_ch);
     curl_close($this->_ch);
    return $response;
  }
  
  /**
    * fetch advertizer domains per campaigns
    * @var cid
  */
    public function getCampaignPerDomain($cid=null,$query=''){
    $this->init();
    $curl = 'https://api.sitescout.com/advertisers/'.$this->_advertiser_id.'/campaigns/'.$cid.'/stats/domains?'.$query;
     $cheader  = array(
      "HOST: api.sitescout.com",
      "Authorization: Bearer {$this->_token}",
      "Content-Type: application/x-www-form-urlencoded",
      "Accept: application/json"
    );
    curl_setopt($this->_ch, CURLOPT_URL, $curl);
    curl_setopt($this->_ch, CURLOPT_HEADER, true);
    curl_setopt($this->_ch, CURLOPT_HTTPHEADER, $cheader);
    curl_setopt($this->_ch, CURLOPT_TIMEOUT, $this->_ch_time_out);
    curl_setopt($this->_ch, CURLOPT_HTTPGET, 1);
    curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($this->_ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($this->_ch);
    
    curl_close($this->_ch);
    return $response;
  }
  
  /**
    * fetch advertizer creatives per campaigns
    * @var cid
  */
  public function getCampaignPerCreative($cid=null,$query=''){
  $this->init();
    $curl = 'https://api.sitescout.com/advertisers/'.$this->_advertiser_id.'/campaigns/'.$cid.'/stats/creatives?'.$query;
     $cheader  = array(
      "HOST: api.sitescout.com",
      "Authorization: Bearer {$this->_token}",
      "Content-Type: application/x-www-form-urlencoded",
      "Accept: application/json"
    );
    curl_setopt($this->_ch, CURLOPT_URL, $curl);
    curl_setopt($this->_ch, CURLOPT_HEADER, true);
    curl_setopt($this->_ch, CURLOPT_HTTPHEADER, $cheader);
    curl_setopt($this->_ch, CURLOPT_TIMEOUT, $this->_ch_time_out);
    curl_setopt($this->_ch, CURLOPT_HTTPGET, 1);
    curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($this->_ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($this->_ch);
    curl_close($this->_ch);
    return $response;
  }
  

}
