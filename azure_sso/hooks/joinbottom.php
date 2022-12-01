<?php
if (count(get_included_files()) ==1) die(); //Direct Access Not Permitted
global $settings, $user, $db, $us_url_root, $abs_us_root;

if ($settings->azurelogin==1 && !$user->isLoggedIn()){
  require_once $abs_us_root.$us_url_root.'usersc/plugins/azure_sso/assets/azure_sso.php';
}
?>
