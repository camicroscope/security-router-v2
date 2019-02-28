function logInSuccess(authResult){
  console.log(authResult)
  var token = authResult.getAuthResponse().access_token;
  console.log(token)
  $.post("security/server.php?logIn", {
      token: token
    },
    function(response) {
      console.log(response);
      if ('logIn' == response) {
        window.location = 'select.php';
      } else if ('signUp' == response) {
        window.location = 'security/request.php?doAction=signUp';
      }
    }
  );
}

function logInError(e){
  console.log('There was an error: ' + e);
}
// we don't need this, but for odd compatibility issues I guess??
function logInCallback(authResult) {
  console.log(authResult)
  console.log("calling log in");
  if (authResult['code']) {
    // Send the code to the server
    $.post("security/server.php?logIn", {
        code: authResult['code']
      },
      function(response) {
        console.log(response);
        if ('logIn' == response) {
          window.location = 'select.php';
        } else if ('signUp' == response) {
          window.location = 'security/request.php?doAction=signUp';
        }
      }
    );
  } else if (authResult['error']) {
    // There was an error.
    // Possible error codes:
    //   "access_denied" - User denied access to your app
    //   "immediate_failed" - Could not automatially log in the user
    console.log('There was an error: ' + authResult['error']);
  }
}
