
# UserSpice Azure Active Directory Plugin

This plugin allows you to use Microsoft Azure Active Directory for logging into UserSpice.

UserSpice can be downloaded from their [website](https://userspice.com/) or on [GitHub](https://github.com/mudmin/UserSpice5)

## Setting Up

1. Extract and copy the azure_sso plugin folder into /usersc/plugins/

2. Open UserSpice Admin Panel and install plugin.

3. Create an application on Azure

4. Generate a client secret

5. Configure plugin with information

  
## Creating an Application


Go to the [Azure Portal](https://portal.azure.com/#view/Microsoft_AAD_RegisteredApps/ApplicationsListBlade) and select New Application. If you already have an application you can skip this step.
  
Name your application, this is what your users will see when they are logging in, so probably want to make it match your website's name.

Choose whether you want to allow only your tenant, multitenant, multitenant and personal, or only personal. You will need to configure the plugin with the same option you select here. Multitenant apps will require you to become a verified publisher.
  
For the OAuth Redirect URI, you can copy the automatically generated URL from the plugin configuration, or it is `YOUR_URL/usersc/plugins/azure_sso/assets/oauth_success.php` replacing `YOUR_URL` with the location of your UserSpice install.

Click ``Register`` when completed.

You will see your ``Application (client) ID`` you will need this to configure the plugin.

On the left hand side click on ``Certificates & Secrets``. Generate a new client secret. Choose your description and length which can be up to 24 months. 

You will need to replace this secret once it expires. 

You will need the ``value`` from this secret and you will no longer be able to copy it once you navigate away from the page.

  

## Plugin Configuration

Setting up the plugin is simple using the information from Azure.

Azure Client ID: Your Azure Application's Client ID

Azure Client Secret: Your Azure Application's Client Secret

Azure Callback URL (Full URL Path): This is automatically generated on install. If this is wrong it should be replaced by `YOUR_URL/usersc/plugins/azure_sso/assets/oauth_success.php` replacing `YOUR_URL` with the location of your UserSpice install.

UserSpice Final Redirect (Full URL Path): Enter the full path of the URL where you would like users to be redirected after logging in.

Tenant Type: Choose your tenant type that you selected in Azure.

Azure Tenant: If you are using a single tenant this will be the domain name of the tenant ex: ``userspice.com``

## Integration

The plugin will automatically match the user's primary email with any existing user accounts. It uses the unique object ID of the user in case they change their email it will automatically match to the new email and change their account.

Need to run custom code after login or signup? Use the `usersc/includes/oauth_success_redirect.php` This file is included before the redirect and any code will be ran.

  

## Questions

Any issues? Feel free to open an issue on Github or make a Pull Request.

Need help? Add me on Discord: ``BangingHeads#0001`` or join the UserSpice Discord below and ask #comm-plugin-support.

Any help with UserSpice can be asked in their [Discord](https://discord.gg/j25FeHu).