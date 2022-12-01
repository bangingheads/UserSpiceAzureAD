<?php

require_once "vendor/autoload.php";
require "provider.php";

$provider->scope = 'openid profile email';

$authorizationUrl = $provider->getAuthorizationUrl(['scope' => $provider->scope]);
$_SESSION['OAuth2.state'] = $provider->getState();

?>
<a href="<?=htmlspecialchars($authorizationUrl)?>">
  <img class="img-responsive" src="<?=$us_url_root?>usersc/plugins/azure_sso/assets/signinwithmicrosoft.png" alt=""/></a>