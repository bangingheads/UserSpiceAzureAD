<?php
require_once '../../../../users/init.php';
require "provider.php";

$whereNext=$settings->finalredir;

if (empty(Input::get('state')) || (isset($_SESSION['OAuth2.state']) && Input::get('state') !== $_SESSION['OAuth2.state'])) {
    if (isset($_SESSION['OAuth2.state'])) {
        unset($_SESSION['OAuth2.state']);
    }
    Redirect::to($us_url_root);
    die();
}
try {

  $token = $provider->getAccessToken('authorization_code', [
    'scope' => $provider->scope,
    'code' => Input::get('code'),
  ]);

  $resourceOwner = $provider->getResourceOwner($token);

  $name = $resourceOwner->claim("name");  
  $names = explode(" ", $name, 2);
  if (count($names) === 2) {
    $firstName = $names[0];
    $lastName = $names[1];
  } else {
    $firstName = $name;
    $lastName = "";
  }

  $oid = $resourceOwner->claim("oid");
  $email = $resourceOwner->claim("email");

} catch (Exception $e) {
	unset($_SESSION['OAuth2.state']);
  Redirect::to($us_url_root);
	die();
}

$checkExistingQ = $db->query("SELECT * FROM users WHERE email = ? OR msft_oid = ?", [$email, $oid]);

$CEQCount = $checkExistingQ->count();

//Existing UserSpice User Found
if ($CEQCount > 0) {
  $checkExisting = $checkExistingQ->first();
  $newLoginCount = $checkExisting->logins+1;
  $newLastLogin = date("Y-m-d H:i:s");

  $fields = ['logins'=> $newLoginCount, 'last_login'=> $newLastLogin, 'email'=> $email, 'msft_oid'=> $oid];

  $db->update('users', $checkExisting->id, $fields);

  $sessionName = Config::get('session/session_name');
  Session::put($sessionName, $checkExisting->id);

  $hooks = getMyHooks(['page'=>'loginSuccess']);
  includeHook($hooks,'body');

  include $abs_us_root . $us_url_root . "usersc/includes/oauth_success_redirect.php";
  Redirect::to($whereNext);
  die();
}


if ($settings->registration == 0) {
  session_destroy();
  Redirect::to($us_url_root.'users/join.php');
  die();
}


// No Existing UserSpice User Found
$preQCount = $db->query("SELECT username FROM users WHERE username = ?",array($email))->count();
if ($preQCount == 0) {
  $username = $email;

// This should hopefully never happen for emails
} else {
  for($i=0;$i<999;$i++) {
    $preQCount = $db->query("SELECT username FROM users WHERE username = ?",array($email.$i))->count();
    if($preQCount == 0) {
      $username = $email.$i;
      break;
    }
  }
}

$date = date("Y-m-d H:i:s");
$fields = [
  'fname'=> $firstName,
  'lname'=> $lastName, 
  'email'=> $email, 
  'username'=> $username, 
  'permissions'=> 1,
  'logins'=> 1,
  'join_date'=> $date, 
  'last_login'=> $date, 
  'email_verified'=> 1,
  'password'=> NULL,
  'msft_oid'=> $oid,
];

$db->insert('users', $fields);
$theNewId = $db->lastId();

$db->query("INSERT INTO user_permission_matches SET `user_id` = ?, permission_id = 1", [$theNewId]);

include $abs_us_root . $us_url_root.'usersc/scripts/during_user_creation.php';

$sessionName = Config::get('session/session_name');
Session::put($sessionName, $theNewId);


include $abs_us_root . $us_url_root . "usersc/includes/oauth_success_redirect.php";
Redirect::to($whereNext);

?>
