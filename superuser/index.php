<?php

  function fetchData($dataUrl){

      $cSession = curl_init();
      try {
          $ch = curl_init();

          if (FALSE === $ch)
              throw new Exception('failed to initialize');


          curl_setopt($ch,CURLOPT_URL, $dataUrl);
          curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
          curl_setopt($ch,CURLOPT_HEADER, false);

          $content = curl_exec($ch);

          if (FALSE === $content)
              throw new Exception(curl_error($ch), curl_errno($ch));
      
          // ...process $content now
      } catch(Exception $e) {
    
          $content = "Error";
          return $content;
         
      }
     
      $content_json = json_decode($content);
      return $content_json; 

  }


    session_start();
    
    $dataUrl = "http://quip-data:9099/services/Camicroscope_DataLoader/DataLoader/query/getAll";      
    $apiKey = $_SESSION["api_key"];    
    $dataUrl = $dataUrl . "?api_key=".$apiKey;    
    $allImages_json = array();   	
    $allImages_json = fetchData($dataUrl);
    
    $noneAssignImageArray = array();
    $assignedImageArray = array();
    $imageProcessingArray = array();
    $imageLockedArray = array();
    $imageCuratedArray = array();
    
    $recordPerPage=30;
    
    $tag_num=$_GET['tag'];
    if(empty($_GET['tag']))
     $tag_num=1;     
    //echo $tag_num;
    $tag_head_id=$tag_num . 'a0';
    $tag_body_id=$tag_num . 'a'; 
    
    $pageNum=$_GET['pageNum'];
    if(empty($_GET['pageNum']))
     $pageNum=1;
     
    $page_link_id=$tag_body_id . "_" . $pageNum ; 
    
    $index2=0;
    for ($i = 0; $i < count($allImages_json); $i++) {
       $item=$allImages_json[$i];      
       $a = (array)$item;       
       $assign_to=$a['assign_to'];
       if(empty($assign_to)){
         $noneAssignImageArray[$index2] = $a;
         $index2=$index2+1;
       }
    }   
    $total_record2=count($noneAssignImageArray);    
    $pageAll2=ceil($total_record2/$recordPerPage);
    $startNumber2=($pageNum-1)*$recordPerPage;
    $endNumber2=$pageNum*$recordPerPage;   
    if($total_record2 < $recordPerPage ){
      $startNumber2 =0;
      $endNumber2 = $total_record2;
    }
     if($endNumber2 > $total_record2 ){     
      $endNumber2 = $total_record2;
    }
    

    $index3=0;
    for ($i = 0; $i < count($allImages_json); $i++) {
       $item=$allImages_json[$i];      
       $a = (array)$item;       
       $assign_to=$a['assign_to'];
       if(!empty($assign_to)){       
         $assignedImageArray[$index3] = $a;
         $index3=$index3+1;
       }
    }   
    $total_record3=count($assignedImageArray);      
    $pageAll3=ceil($total_record3/$recordPerPage);
    $startNumber3=($pageNum-1)*$recordPerPage;
    $endNumber3=$pageNum*$recordPerPage;   
    if($total_record3 < $recordPerPage ){
      $startNumber3 =0;
      $endNumber3 = $total_record3;
    }
    if($endNumber3 > $total_record3 ){     
      $endNumber3 = $total_record3;
    }
    
    $index4=0;
    for ($i = 0; $i < count($allImages_json); $i++) {
       $item=$allImages_json[$i];      
       $a = (array)$item;       
       $is_processing=$a['is_processing'];
       if($is_processing=="yes"){       
         $imageProcessingArray[$index4] = $a;
         $index4=$index4+1;
       }
    }   
    $total_record4=count($imageProcessingArray);      
    $pageAll4=ceil($total_record4/$recordPerPage);
    $startNumber4=($pageNum-1)*$recordPerPage;
    $endNumber4=$pageNum*$recordPerPage;   
    if($total_record4 < $recordPerPage ){
      $startNumber4 =0;
      $endNumber4 = $total_record4;
    }
    if($endNumber4 > $total_record4 ){     
      $endNumber4 = $total_record4;
    }
    
    
    $index5=0;
    for ($i = 0; $i < count($allImages_json); $i++) {
       $item=$allImages_json[$i];      
       $a = (array)$item;       
       $status=$a['status']; 
       if(isset($status) and ($status=="lock" or $status=="Lock")){       
         $imageLockedArray[$index5] = $a;
         $index5=$index5+1;
       }
    }   
    $total_record5=count($imageLockedArray);      
    $pageAll5=ceil($total_record5/$recordPerPage);
    $startNumber5=($pageNum-1)*$recordPerPage;
    $endNumber5=$pageNum*$recordPerPage;   
    if($total_record5 < $recordPerPage ){
      $startNumber5 =0;
      $endNumber5 = $total_record5;
    }
    if($endNumber5 > $total_record5 ){     
      $endNumber5 = $total_record5;
    }
    
    
    $index6=0;
    for ($i = 0; $i < count($allImages_json); $i++) {
       $item=$allImages_json[$i];      
       $a = (array)$item;       
       $is_curated=$a['is_curated']; 
       if($is_curated=="yes"){       
         $imageCuratedArray[$index6] = $a;
         $index6=$index6+1;
       }
    }   
    $total_record6=count($imageCuratedArray);      
    $pageAll6=ceil($total_record6/$recordPerPage);
    $startNumber6=($pageNum-1)*$recordPerPage;
    $endNumber6=$pageNum*$recordPerPage;   
    if($total_record6 < $recordPerPage ){
      $startNumber6 =0;
      $endNumber6 = $total_record6;
    }
    if($endNumber6 > $total_record6 ){     
      $endNumber6 = $total_record6;
    }
    
                 
                 
    $userUrl = "http://quip-data:9099/services/u24_user/user_data/query/findUser";      
    $apiKey = $_SESSION["api_key"];    
    $userUrl = $userUrl . "?api_key=".$apiKey;    
    $user_json = array();   	
    $user_json = fetchData($userUrl);
    //print_r($user_json); 
   
    $allUserUrl = "http://quip-data:9099/services/u24_user/user_data/query/findAllBindaasUsers";      
    $apiKey = $_SESSION["api_key"];    
    $allUserUrl = $allUserUrl . "?api_key=".$apiKey;    
    $allUser_json = array();   	
    $allUser_json = fetchData($allUserUrl);
    //print_r($allUser_json);   
    
  ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Super User Images Control</title>

    <style type='text/css'>

        body {
            padding : 10px ;
        }          

        #exTab1 .tab-content {
            color : white;
            background-color: #428bca;
            padding : 5px 15px;
        }

        #exTab2 h3 {
            color : white;
            background-color: #428bca;
            padding : 5px 15px;
        }

        /* remove border radius for the tab */

        #exTab1 .nav-pills > li > a {
            border-radius: 0;
        }

        /* change border radius for the tab , apply corners on top*/

        #exTab3 .nav-pills > li > a {
            border-radius: 4px 4px 0 0 ;
        }

        #exTab3 .tab-content {
            color : white;
            background-color: #428bca;
            padding : 5px 15px;
        }
        
        table, th, td {
       border: 1px solid black;
       border-collapse: collapse;
       } 
       
        th, td {
        padding: 25px;
       }  

      select {
        background-color: #428bca;
       }
      
       /* unvisited link */
      a:link {
        color: red;
      }

       /* visited link */
      a:visited {
       color: green;
      }

     /* mouse over link */
      a:hover {
       color: hotpink;
       background-color: yellow;
      }

     /* selected link */
     a:active {
      color: blue;
      background-color: yellow;
     }
     
     .test {
      color: blue;
      background-color: white;
     }

     input[type=text] {
       background-color: #428bca;
       color: white;
     }  
    </style>
    
    

</head>
<body>
<div><table border=1><tr></tr></table></div>

<div class="container"><h2><a href="/select.php">caMicroscope</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Super User Setup Images Access Control</h2></div>
<div id="exTab1" class="container">
    <ul  class="nav nav-pills">        
        <li id="1a0" class="active"><a href="index.php#1a" data-toggle="tab">Camicroscope User Type</a></li>
        <li id="2a0"><a href="index.php#2a" data-toggle="tab">Assign Images to User</a></li>
        <li id="3a0"><a href="index.php#3a" data-toggle="tab">Images Assigned</a></li>
        <li id="4a0"><a href="index.php#4a" data-toggle="tab">Images Processing</a></li>
        <li id="5a0"><a href="index.php#5a" data-toggle="tab">Images Locked</a></li>
        <li id="6a0"><a href="index.php#6a" data-toggle="tab">Images Curated</a></li>        
    </ul>

    <div class="tab-content clearfix">
        <div class="tab-pane active" id="1a">
            <h3>Set Camicroscope User Type</h3>
            <table cellpadding="4"> 
              <tr>
                <td align="center">First Name</td>
                <td align="center">Last Name</td>
                <td align="center">Email</td>
                <td align="center">User Type</td>  
                <td align="center">Action</td>                              
              </tr>              
              <?php 		          
              for ($i = 0; $i < count($allUser_json); $i++) {
                 $item=$allUser_json[$i];      
                 $a = (array)$item;
                 $fname=$a['fname'];
                 $lname=$a['lname'];
                 $email=$a['email'];
                 $userType=$a['userType']; 
                 $selectStr="<select name='userType'><option>user</option><option>superuser</option></select>";  
                 if(!empty($userType))                                               
                   echo "<tr><td>" . $fname . "</td><td>" . $lname . "</td><td>" . $email . "</td><td>" . $userType . "</td><td></td></tr>"; 
                 else
                   echo "<form method='post' action='setUserType.php'><tr><td><input type='text' name='fname' value='" . $fname . "'</td><td><input type='text' name='lname' value='" . $lname . "'</td><td><input type='text' name='email' value='" . $email . "'</td><td>" . $selectStr . "</td><td><input type='submit' value='Assign to' style='background-color:green'></td></tr></form>";                  
               }?>
            </table>           
        </div>
        
        <div class="tab-pane" id="2a">
            <h3>All Images not assigned to</h3>
            <table cellpadding="4"> 
              <tr>
                <td>Case_id</td>
                <td>Width</td>
                <td>Height</td>
                <td>Status</td>
                <td align="center">Student Assigned to</td>
                <td>Action</td>
              </tr>              
              <?php            

                for ($i = $startNumber2; $i < $endNumber2; $i++) {
                 $a=$noneAssignImageArray[$i];      
                 $case_id=$a['case_id'];
                 $width=$a['width'];
                 $height=$a['height'];
                 $assign_to=$a['assign_to'];
                 $status=$a['status'];
                 $selectStr="<select name='assign_to'><option selected>-- Select an User's Email --</option>";
                 for ($j = 0; $j < count($user_json); $j++) {
                   $record=$user_json[$j];
                   $a2 = (array)$record;
                   $email =$a2['email']; 
                   $selectStr=$selectStr . "<option>" .  $email . "</option>";
                 }
                $selectStr=$selectStr . "</select>"; 
                echo "<form method='post' action='assignTo.php'><tr><td><input type='text' name='case_id' value='" . $a['case_id'] . "'></td><td>" . $a['width'] . "</td><td>" . $a['height'] . "</td><td>Unlocked</td><td>" . $selectStr . "</td><td><input type='submit' value='Assign to' style='background-color:green'></td></tr></form>";                   
               }?>
            </table>
            <br>
            <table cellpadding="4"> 
              <tr>
             <?php 		          
              for ($j = 1; $j < $pageAll2+1; $j++) {  
               $this_id="2a_".$j;            
              if($pageAll2!=1)
                echo '<td id="'.$this_id.'"><a href="index.php?tag=2&pageNum=' . $j . '">Page ' . $j . '</a></td>';
            }?>
            </tr>
            </table>
        </div>        
        
        <div class="tab-pane" id="3a">
            <h3>Images  assigned to students</h3>
             <table cellpadding="4"> 
              <tr>
                <td>Case_id</td>
                <td>Width</td>
                <td>Height</td>
                <td>Status</td>
                <td>Student Assigned to</td>                
              </tr>              
              <?php 		          
              for ($i = $startNumber3; $i < $endNumber3; $i++) {
                 $a=$assignedImageArray[$i];                                   
                 echo "<tr><td>" . $a['case_id'] . "</td><td>" . $a['width'] . "</td><td>" . $a['height'] . "</td><td>" . $a['status'] . "</td><td>" . $a['assign_to'] . "</td></tr>";                   
               }?>
            </table>
            <br>
            <table cellspacing="20"> 
              <tr>
             <?php 		          
              for ($j = 1; $j < $pageAll3+1; $j++) {
               $this_id="3a_".$j;
              if($pageAll3!=1)
                echo '<td id="'.$this_id.'"><a href="index.php?tag=3&pageNum=' . $j . '">Page ' . $j . '</a></td>';
            }?>
            </tr>
            </table>
        </div>
        
        <div class="tab-pane" id="4a">
            <h3>Images  processing (curating) by students</h3>
            <table cellpadding="4"> 
              <tr>
                <td>Case_id</td>
                <td>Width</td>
                <td>Height</td>
                <td>Status</td>
                <td>Student Assigned to</td>                
              </tr>              
              <?php 		          
              for ($i = $startNumber4; $i < $endNumber4; $i++) {
                 $a=$imageProcessingArray[$i];                                                                
                 echo "<tr><td>" . $a['case_id'] . "</td><td>" . $a['width'] . "</td><td>" . $a['height'] . "</td><td>is processing</td><td>" . $a['assign_to'] . "</td></tr>";                   
               }?>
            </table>
            <br>
            <table cellpadding="4"> 
              <tr>
             <?php 		          
             for ($j = 1; $j < $pageAll4+1; $j++) {
               $this_id="4a_".$j;
               if($pageAll4!=1)
                echo '<td id="'.$this_id.'"><a href="index.php?tag=4&pageNum=' . $j . '">Page ' . $j . '</a></td>';
            }?>
            </tr>
            </table>
        </div>
        
        <div class="tab-pane" id="5a">
            <h3>Images  locked by super user</h3>
            <table cellpadding="4"> 
              <tr>
                <td>Case_id</td>
                <td>Width</td>
                <td>Height</td>
                <td>Status</td>
                <td>Student Assigned to</td>                
              </tr>              
              <?php 		          
             for ($i = $startNumber5; $i < $endNumber5; $i++) {
                 $a=$imageLockedArray[$i];                                                                 
                   echo "<tr><td>" . $a['case_id'] . "</td><td>" . $a['width'] . "</td><td>" . $a['height'] . "</td><td>Locked</td><td>" . $a['assign_to'] . "</td></tr>";                   
               }?>
            </table>
            <br>
            <table cellpadding="4"> 
              <tr>
             <?php 		          
             for ($j = 1; $j < $pageAll5+1; $j++) {
               $this_id="5a_".$j;
               if($pageAll5!=1)
                echo '<td id="'.$this_id.'"><a href="index.php?tag=5&pageNum=' . $j . '">Page ' . $j . '</a></td>';
            }?>
            </tr>
            </table>
        </div>
        
        <div class="tab-pane" id="6a">
            <h3>Images have been Curated with composite dataset</h3>
            <table cellpadding="4"> 
              <tr>
                <td>Case_id</td>
                <td>Width</td>
                <td>Height</td>
                <td>Status</td>
                <td>Student Assigned to</td>                
              </tr>              
              <?php 		          
              for ($i = $startNumber5; $i < $endNumber5; $i++) {
                 $a=$imageCuratedArray[$i];                                                   
                   echo "<tr><td>" . $a['case_id'] . "</td><td>" . $a['width'] . "</td><td>" . $a['height'] . "</td><td>Curated</td><td>" . $a['assign_to'] . "</td></tr>";                   
               }?>
            </table>
            <br>
            <table cellpadding="4"> 
              <tr>
             <?php 		          
             for ($j = 1; $j < $pageAll6+1; $j++) {
               $this_id="6a_".$j;
               if($pageAll6!=1)
                echo '<td id="'.$this_id.'"><a href="index.php?tag=6&pageNum=' . $j . '">Page ' . $j . '</a></td>';
            }?>
            </tr>
            </table>
        </div>
        
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

<!-- Optional theme
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
 -->
 
 <script>
   var tagHeadId = "<?php echo $tag_head_id; ?>";	 
   var tagBodyId = "<?php echo $tag_body_id; ?>";	
   var pageLinkId = "<?php echo $page_link_id; ?>";  
   //alert (tagHeadId);
   //alert (tagBodyId);
   //alert (pageLinkId);
   
   var active_item = document.getElementsByClassName("active");   
   //alert(active_item[0].className); 
   var tmp=active_item[0].className.replace("active", "");
   //alert(tmp);
   active_item[0].className = tmp;      
   
   var active_item2 = document.getElementsByClassName("tab-pane active");   
   //alert(active_item2[0].className); 
   var tmp=active_item2[0].className.replace(" active", "");
   //alert(tmp);
   active_item2[0].className = tmp;  
   
   
   var tag_head = document.getElementById(tagHeadId);
   tag_head.className += " active";
    
   var tag_body = document.getElementById(tagBodyId);
   tag_body.className += " active"; 

   var page_link = document.getElementById(pageLinkId);
   if ( typeof(page_link) !== "undefined" && page_link !== null ) {   
     page_link.className= "test";
   }
   
 </script>

</body>
</html>


