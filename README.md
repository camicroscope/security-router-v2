# Security
## User authentication for caMicroscope 

### Enabling Authentication
In order to sign in your users with their Google Accounts, you will need to integrate Google Sign-In into your app.

If you do not wish to sign in users, please see [Disabling Authentication](https://github.com/camicroscope/Security/blob/release/README.md#disabling-authentication).

### Step 1. Setting up Google Sign-In

* First, go to [Google API Console](https://console.developers.google.com/project/_/apiui/apis/library)
* From the drop-down in the top left corner, create a new project
* Next, select Credentials in the left side-bar, then select "OAuth Client ID" in the drop-down, and then "Configure Consent Screen"
* Fill in your URL, etc, and click "Save"
* Then, select "Web application", and fill in the fields
* Finally, copy your **"client ID"** and **"client secret"**


**Ref: [Google Sign-In for Websites](https://developers.google.com/identity/sign-in/web/devconsole-project)**

### Step 2. Configuration

Edit `config/security_config.php`:

* Set `$client_id` and `$client_secret` obtained from Step1.
* Set `$bindaas_trusted_id` and `$bindaas_trusted_secret`.
* Set `$bindaas_trusted_url` as the IP/hostname of the data container.
* Set `$mongo_client_url` as IP/hostname of data container.  


### Disabling Authentication

To disable authentication edit `config.ini`:

* Set `disable_security=true`
* You should be able to see the `/select.php` now when you launch the application from the browser.

