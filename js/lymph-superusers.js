$(document).ready(function() {
          
    var msgEnterEmail = 'Please enter the gmail address.';
    var msgNotValidEmail = 'The value is not a valid email address.';
    var msgSuperuserExists = 'This lymphocyte superuser already exists.';
    var msgSuperuserNotExists = "This lymphocyte superuser does not exist.";
    var msgSessionNotEstablished = 'Error on post.  Your session could not be established.  Please login to QuIP to meet access policy requirements. ';
    var msgFormError = 'Form Error';
    var msgResponseNoData = 'No data';
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    var role = lymphUser.superuserRole;
        
    $('#submitButtonAssign').click(function() {
            
        var email = document.getElementById("emailAssign").value;
        email = email.trim().toLowerCase();
            
        var superuserData = {
            'email': email,
            'role': lymphUser.superuserRole
        };
            
        if (email === "") {
            document.getElementById("msgAssign").innerHTML = msgEnterEmail;
            return false;
        }
        
        if(!(email).match(emailPattern)) {
            document.getElementById("msgAssign").innerHTML = msgNotValidEmail;
            return false;
        } 
            
        $.ajax({
            'type': 'GET',
            url: '../camicroscope/api/Data/lymphocyteSuperusers.php?email=' + email + '&role=' + role,
            success: function(response) {
                var msgConfirmAssign = 'Are you sure you want to assign ' + email + ' as a Lymphocyte App superuser?';
                var msgUserAssigned  = 'User ' + email + ' was assigned rights as a Lymphocyte App superuser';
                        
                if (response.trim().toLowerCase() !== msgResponseNoData.toLowerCase()) {
                    var data = JSON.parse(response);
                    console.log("Fetched data users length: " + data.length);
                    if (data.length === 0 ) {
                        if(confirm(msgConfirmAssign)) {
                            //console.log('superuserData: ' + superuserData.email)
                            $.ajax({
                                'type': 'POST',
                                url: '../camicroscope/api/Data/lymphocyteSuperusers.php',
                                data: superuserData,
                                success: function (res, err) {
                                    //console.log("response: ");
                                    console.log(res);
                                    console.log(err);
                                    console.log('successfully posted');
                                    document.getElementById('msgAssign').innerHTML = msgUserAssigned;
                                }
                            });
                        }else{
                            document.getElementById("msgAssign").innerHTML = "";
                        }
                    } else {
                        document.getElementById("msgAssign").innerHTML = msgSuperuserExists;
                    }
                } else {
                    document.getElementById("msgAssign").innerHTML = msgSessionNotEstablished;
                }
            },  //end success
            error: function(response) {
                console.log("error on post: " + response);
                document.getElementById("msgAssign").innerHTML = msgFormError;
            }
        });
		
        return false;
    });  // end 'submitButtonAssign' click
            
                
    // start remove superuser
    $('#submitButtonRemove').click(function() {
            
        var email = document.getElementById("emailRemove").value;
        email = email.trim().toLowerCase();
            
        if (email === "") {
            document.getElementById("msgRemove").innerHTML = msgEnterEmail;
            return false;
        }
        
        if(!(email).match(emailPattern)) {
            document.getElementById("msgRemove").innerHTML = msgNotValidEmail;
            return false;
        } 
            
        $.ajax({
            'type': 'GET',
            url: '../camicroscope/api/Data/lymphocyteSuperusers.php?email=' + email + '&role=' + role,
            success: function(response) {
                var msgConfirmRemove = 'Are you sure you want to remove ' + email + ' as a Lymphocyte App superuser?';
                var msgUserRemoved  = 'User ' + email + ' was successfully removed as a Lymphocyte App superuser.';
                         
                if (response.trim().toLowerCase() !== msgResponseNoData.toLowerCase()) {
                    var data = JSON.parse(response);
                    console.log("Fetched data users length: " + data.length);
                    if (data.length !== 0) {
                        if (confirm(msgConfirmRemove)) {
                            //console.log('superuserData: ' + superuserData.email)
                            $.ajax({
                                'type': 'DELETE',
                                url: '../camicroscope/api/Data/lymphocyteSuperusers.php?email='+ email + '&role=' + role,
                                success: function (res, err) {
                                    //console.log("response: ");
                                    console.log(res);
                                    console.log(err);
                                    console.log('successfully deleted');
                                    document.getElementById('msgRemove').innerHTML = msgUserRemoved;
                                }
                            });
                        }else {
                            document.getElementById("msgAssign").innerHTML = "";
                        }
					} else if (data.length === 0) {
						document.getElementById("msgRemove").innerHTML = msgSuperuserNotExists;          
					} else {
						return false;
					}
                             
				} else {
					document.getElementById("msgRemove").innerHTML = msgSessionNotEstablished;
				}
			},  //end success
			error: function(response) {
				console.log("error on delete: " + response);
				document.getElementById("msgAssign").innerHTML = msgFormError;
			}
		});
          
        return false;
	});  // end remove superuser
    
    $('[data-toggle="tooltip"]').tooltip({
        placement : 'bottom'
    });
});  //end ready

$('.closeall').click(function(){
  $('.panel-collapse.in')
    .collapse('hide');
});

$('.openall').click(function(){
  $('.panel-collapse:not(".in")')
    .collapse('show');
});
    
