# Security
Security, user authentication for caMicroscope 


## Step 1. Setting up Google Sign-In

* Setup [Google sign-in](https://developers.google.com/+/web/signin/)

Make sure you Enable the Google+ API service.
Also take note of the *client ID* and *client secret*

## Step 2. Configuration

Edit `config/security_config.php`.
* Set `$client_id` and `$client_secret` obtained from Step1.
* Set `$bindaas_trusted_id` and `$bindaas_trusted_secret`.
* Set `$bindaas_trusted_url` as the IP/hostname of the data container.
* Set `$mongo_client_url` as IP/hostname of data container.  

## Step 3. Enabling authentication in Bindaas

* Login to the `data` container. 
* Edit `/root/bindaas/bin/bindaas.config.json`. Set `enableAuthentication: true`. (See: https://github.com/camicroscope/DataDockerContainer/blob/master/bindaas.config.json#L5)
* Restart bindaas. 


## Step 4. Default super user account

Super user account: Default user name is admin and 'quip2017' as password. Super user can change his/her password,list all users,remove users and add users from UI and MongoDB to the system from URL yourhost/camicSignup/index.html.
 
 
	   
