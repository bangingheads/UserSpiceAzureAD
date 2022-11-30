<?php
/*
UserSpice 5
An Open Source PHP User Management System
by the UserSpice Team at http://UserSpice.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>

<?php

require_once "vendor/autoload.php";
require "provider.php";

$baseGraphUri = $provider->getRootMicrosoftGraphUri(null);
$provider->scope = 'openid profile email';

$authorizationUrl = $provider->getAuthorizationUrl(['scope' => $provider->scope]);
$_SESSION['OAuth2.state'] = $provider->getState();

?>
<a href="<?=htmlspecialchars($authorizationUrl)?>">
  <img class="img-responsive" align=right src="<?=$us_url_root?>usersc/plugins/azure_sso/assets/signinwithmicrosoft.png" alt=""/></a>
