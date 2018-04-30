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

Configuration is done through a headerless ini file, Config.ini

| Key | Function | Default |
| --- | --- | --- | 
|trusted_secret| bindaas trusted secret | - |
|disable_security| a boolean which disables user login if true | false |
|trusted_id | the application name for bindaas | camicSignup |
|trusted_url | the bindaas endpoint for trust |http://quip-data:9099/trustedApplication |
|client_id | client id from google oauth (Step 1) | an unusable value|
|client_secret | client secret from google oauth (Step 1) | an unusable value|
|redirect_uri | the redirection to take after oauth (Step 1) | postmessage|
|title| the title as shown on the page title and some headers | caMicroscope|
|suffix | a tagline printed after the title on the login page | empty |
|description | a description of the application/deployment | Look at Slides |
| footer | designed for grant or contact information | caMicroscope – A Digital Pathology Integrative Query System; Ashish Sharma PI Emory |
|download_link | the url linked to on the download button | https://github.com/camicroscope |
|folder_path| the relative path of the folder | \/ |
| dataHost | the data container’s name and port | quip-data:9099 |
|kueHost | the jobs container’s name and port | quip-jobs:3000 |
 


### Disabling Authentication

To disable authentication edit `config.ini`:

* Set `disable_security=true`
* You should be able to see the `/select.php` now when you launch the application from the browser.

