 <?php
if (!in_array($user->data()->id, $master_account)) {
    Redirect::to($us_url_root . 'users/admin.php');
} //only allow master accounts to manage plugins! 
?>

<?php
include "plugin_info.php";
pluginActive($plugin_name);
?> 
<div class="content mt-3">
  <div class="row">
    <div class="col-6 offset-3">
      <h2>Azure AD Settings</h2>
      <strong>Please note:</strong> You must create an Azure AD App Registration to use their SSO. More information can be found on the plugin Github README <a href="https://github.com/bangingheads/UserSpiceAzureAD" target="_blank"><font color="blue">here.</font></a><br><br>


      <!-- left -->
      <div class="form-group">
        <label for="azurelogin">Enable Azure AD SSO Login</label>
        <span style="float:right;">
          <label class="switch switch-text switch-success">
            <input id="azurelogin" type="checkbox" class="switch-input toggle" data-desc="Azure AD SSO Login" <?php if($settings->azurelogin==1) echo 'checked="true"'; ?>>
            <span data-on="Yes" data-off="No" class="switch-label"></span>
            <span class="switch-handle"></span>
          </label>
        </span>
      </div>

      <div class="form-group">
        <label for="azureclientid">Azure Client ID</label>
        <input type="password" class="form-control ajxtxt" data-desc="Azure Client ID" name="azureclientid" id="azureclientid" value="<?=$settings->azureclientid?>">
      </div>

      <div class="form-group">
        <label for="azureclientsecret">Azure Client Secret</label>
        <input type="password" class="form-control ajxtxt" data-desc="Azure Client Secret" name="azureclientsecret" id="azureclientsecret" value="<?=$settings->azureclientsecret?>">
      </div>

      <div class="form-group">
        <label for="azurecallback">Azure Callback URL</label>
        <input type="text" class="form-control ajxtxt" data-desc="Azure Callback URL" name="azurecallback" id="azurecallback" value="<?=$settings->azurecallback?>">
      </div>

      <div class="form-group">
        <label for="finalredir">UserSpice Final Redirect</label>
        <input type="text" class="form-control ajxtxt" data-desc="UserSpice Redirect" name="finalredir" id="finalredir" value="<?=$settings->finalredir?>">
      </div>

      <div class="form-group">
        <label for="multitenant">Tenant Type</label>
        <select id="azuremulti" class="form-control ajxnum" data-desc="Tenant Type" name="azuremulti">
            <option value="0" <?php if($settings->azuremulti==0) echo 'selected'?>>Single Tenant</option>
            <option value="1" <?php if($settings->azuremulti==1) echo 'selected'?>>Multitenant / Multitenant with Public</option>
            <option value="2" <?php if($settings->azuremulti==2) echo 'selected'?>>Public</option>
        </select>
      </div>

      <div class="form-group">
        <label for="azuretenant">Azure Tenant</label>
        <input type="text" class="form-control ajxtxt" data-desc="Azure Tenant" name="azuretenant" id="azuretenant" value="<?=$settings->azuretenant?>">
      </div>
  	</div>
  </div>
</div>


<script>
$(document).ready(function() {
  $("#azuretenant").prop("disabled", !!parseInt($('#azuremulti').val()));
});

$('#azuremulti').change(function() {
  $("#azuretenant").prop("disabled", !!parseInt($('#azuremulti').val()));
})
</script>