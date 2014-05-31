<?php
/**
* Basic interaction with the SiteScout API Wrapper Class.
* Replace CLIENT ID and CLIENT SECRET with API credentials
*/

require_once('class.sitescout.php');

// set user credentials
$api = new API('CLIENT ID','CLIENT SECRET');
$api->setPostFields('grant_type=client_credentials&scope=STATS AUDIENCES CONTROL');
$api->setApiUrl('https://api.sitescout.com/oauth/token');
$res = $api->execute();

// fetch Advertizer Id from header
preg_match_all('/X-Advertiser-Id:\s[0-9]+/x', $res, $advertizer_str);
$advertizer = $advertizer_str[0][0];
preg_match_all('/[0-9]+/x', $advertizer, $advertizer_json);
$setAdvertiserId = $advertizer_json[0][0];

// fetch token information from header
preg_match_all('/\{(?:[^{}]|(?R))*\}/x', $res, $res_json);
$json_data = $res_json[0][0];
$object = json_decode($json_data);

// set Advertizer ID
$api->setAdvertiserId($setAdvertiserId);

// set token
$api->setToken($object->access_token);


//********************************* code to fetch Advertizer Campaigns *****************************/
/*
$campaigns = $api->getCampaigns();
preg_match_all('/\{(?:[^{}]|(?R))*\}/x', $campaigns, $campaigns_json);
$campaigns_json_data = $campaigns_json[0][0];
$campaigns_json_data_obj = json_decode($campaigns_json_data);
echo '<pre>';
print_r($campaigns_json_data_obj);
die;
*/


//**************************** code to fetch Campaign details **************************************/
/*
$campaign = $api->getCampaign(campaignID);
preg_match_all('/\{(?:[^{}]|(?R))*\}/x', $campaign, $campaign_json);
$campaign_json_data = $campaign_json[0][0];
$campaign_json_data_obj = json_decode($campaign_json_data);
echo '<pre>';
print_r($campaign_json_data_obj);
die;
*/

//***************************** code to fetch Sites Per Campaign **************************************/
/*
$campaignPerSite = $api->getCampaignPerSite(campaignID);
preg_match_all('/\{(?:[^{}]|(?R))*\}/x', $campaignPerSite, $campaignPerSite_json);
$campaignPerSite_json_data = $campaignPerSite_json[0][0];
$campaignPerSite_json_data_obj = json_decode($campaignPerSite_json_data);
echo '<pre>';
print_r($campaignPerSite_json_data_obj);
die;
*/
/*
//***************************** code to fetch Creatives Per Campaign ************************************/
/*
$campaignPerSite = $api->getCampaignPerCreative(campaignID);
preg_match_all('/\{(?:[^{}]|(?R))*\}/x', $campaignPerSite, $campaignPerSite_json);
$campaignPerSite_json_data = $campaignPerSite_json[0][0];
$campaignPerSite_json_data_obj = json_decode($campaignPerSite_json_data);
echo '<pre>';
print_r($campaignPerSite_json_data_obj);
die;
*/
//******************************* code to fetch Site Stats *************************************************/
/*
$campaignPerSite = $api->getCampaignSiteStats(campaignID,'site ref id');
preg_match_all('/\{(?:[^{}]|(?R))*\}/x', $campaignPerSite, $campaignPerSite_json);
$campaignPerSite_json_data = $campaignPerSite_json[0][0];
$campaignPerSite_json_data_obj = json_decode($campaignPerSite_json_data);
echo '<pre>';
print_r($campaignPerSite_json_data_obj);
*/
