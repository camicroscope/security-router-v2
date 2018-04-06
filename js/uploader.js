$(document).ready(function() {
  $('.modal').modal();
  var bar = $('#progressbar');
  var status = $('#status');
  var options = {
    url: 'quip-loader/submitData',
    dataType: 'json',
    beforeSend: function() {
      document.getElementById("submitButton").disabled = true;
      document.getElementById("status").innerHTML = "Uploading...";
      document.getElementById("progressbar").classList.remove("red");
      document.getElementById("progressbar").classList.remove("green");
      status.empty();
      var percentVal = '0%';
      bar.width(percentVal);
    },
    uploadProgress: function(event, position, total, percentComplete) {
      var percentVal = percentComplete + '%';
      bar.width(percentVal);
    },
    complete: function(xhr) {
      document.getElementById("progressbar").classList.remove("red");
      document.getElementById("progressbar").classList.add("green");
    },
    error: function(response) {
      document.getElementById("submitButton").disabled = false;
      //console.log(document.getElementById("imageid").innerHTML);
      console.log(response.status);
      document.getElementById("status").innerHTML =
        "Problem with uploading.";
      Materialize.toast('Problem with uploading.', 4000);
      document.getElementById("progressbar").classList.add("red");
    },
    success: function(response) {
      document.getElementById("submitButton").disabled = false;
      console.log(response.status);
      document.getElementById("uploadme").reset();
      document.getElementById("status").innerHTML =
        "Image file is uploaded.";
      Materialize.toast('Upload Complete', 4000);
    }
  };
  $('#uploadme').submit(function() {
    var imageid = document.getElementById("imageid").value;
    imageid = imageid.trim()
    if (imageid == "") {
      document.getElementById("status").innerHTML =
        "Please enter an image ID!";
      return false;
    }
    var regexp = /^[a-zA-Z0-9-_]+$/;
    if (imageid.search(regexp) == -1) {
      document.getElementById("status").innerHTML =
        "Image ID can only contain characters (A-Z,a-z,0-9,-,_)!";
      return false;
    }
    if ($("#upload_image").val() == "") {
      document.getElementById("status").innerHTML =
        "Please select an image file!";
      return false;
    }
    // remove space
    imageid = imageid.split(' ').join('_');
    document.getElementById("imageid").value = imageid;
    $.ajax({
      dataType: "JSON",
      url: "camicroscope/api/Data/osdMetadataRetriever.php?imageId=" +
        imageid,
      success: function(response) {
        if (response[0] === null) {
          $('#uploadme').ajaxSubmit(options);
        } else {
          document.getElementById("status").innerHTML =
            "Image ID already exists!";
        }
      },
      error: function(response) {
        console.log("error on post");
        Materialize.toast('Form Error!', 4000);
      }
    });
    return false;
  });
});
