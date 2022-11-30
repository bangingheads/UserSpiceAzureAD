<?php

require_once __DIR__ . '/../../../../users/init.php';
require_once "vendor/autoload.php";

$db=DB::getInstance();

$settings=$db->query("SELECT * FROM settings")->first();

$azureClientId=$settings->azureclientid;
$azureClientSecret=$settings->azureclientsecret;
$azureCallback=$settings->azurecallback;
$azureMulti = $settings->azuremulti;
$azureTenant = $settings->azuretenant;

$provider = new TheNetworg\OAuth2\Client\Provider\Azure([
    'clientId'          => $azureClientId,
    'clientSecret'      => $azureClientSecret,
    'redirectUri'       => $azureCallback,
    'scopes'            => ['openid'],
    'defaultEndPointVersion' => '2.0'
]);

$tenants = [$azureTenant, "common", "consumers"];

$provider->tenant = $tenants[$azureMulti];