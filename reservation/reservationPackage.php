<?php
  session_start();
$hostname = "localhost";
$username = "root";
$password = "";
$databaseName = "senordepacencia";
// define variables and set to empty values
$firstNameErr="";
$lastnameErr="";
$contactnoErr="";
$birthdateErr="";
$lotnoErr="";
$streetErr="";
$barangayErr="";
$cityErr="";

$eventdateErr="";
$servicestartErr="";
$serviceendErr="";
$eventtypeErr="";
$numberofpaxErr="";
$venueErr="";
$motifErr="";

$lastname = "";
$firstname="";
$contactno="";
$birthdate="";
$lotno="";
$street="";
$barangay="";
$city="";

$datereserved = date("Y-m-d");
$eventdate="";
$servicestart="";
$serviceend="";
$eventtype="";
$numberofpax="";
$venue="";
$motif="";

$packageprice=0;
$optional="";
$please="";
$optional1="";
$optional2="";
$optional3="";
$optional4="";
$counter="";
$count="";
$total="";
if(isset($_SESSION['username'])){
  $user = $_SESSION['username'];
}


$connect = mysqli_connect($hostname, $username, $password, $databaseName);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try{
    $connect = mysqli_connect($hostname, $username, $password, $databaseName);
    
}catch(Exception $ex)
{
    echo 'Error';
}

$query = "SELECT * FROM eventtype";

$result1 = mysqli_query($connect, $query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["firstname"])) {
    $firstNameErr = "First Name is required";
  } else {
    $firstname = test_input($_POST["firstname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) {
      $firstNameErr = "Only letters and white space allowed"; 
    }
  }
  if (empty($_POST["lastname"])) {
    $lastnameErr = "Last Name is required";
  } else {
    $lastname = test_input($_POST["lastname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$lastname)) {
      $lastnameErr = "Only letters and white space allowed"; 
    }
  }
if (empty($_POST["contactno"])) {
    $contactnoErr = "Contact Number is required";
  } else {
    $contactno = test_input($_POST["contactno"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[0-9 ]*$/",$contactno)) {
      $contactnoErr = "Only numerical value allowed"; 
    }
  }
  if (empty($_POST["birthdate"])) {
    $birthdateErr = "Birthdate is required";
  } else {
    $birthdate = test_input($_POST["birthdate"]);
    // check if name only contains letters and whitespace 
  }
  if (empty($_POST["lotno"])) {
    $lotnoErr = "Lot No/Blg No is required";
  } else {
    $lotno = test_input($_POST["lotno"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z 0-9 ]*$/",$lotno)) {
      $lotnoErr = "Only letters, numbers and white space allowed"; 
    }
  }
   if (empty($_POST["street"])) {
    $streetErr = "Street is required";
  } else {
    $street = test_input($_POST["street"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z 0-9]*$/",$street)) {
      $streetErr = "Only letters, numbers and white space allowed"; 
    }
  }
  if (empty($_POST["barangay"])) {
    $barangayErr = "Barangay is required";
  } else {
    $barangay = test_input($_POST["barangay"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z 0-9]*$/",$barangay)) {
      $barangayErr = "Only letters, numbers and white space allowed"; 
    }
  }
  if (empty($_POST["city"])) {
    $cityErr = "City is required";
  } else {
    $city = test_input($_POST["city"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z 0-9]*$/",$city)) {
      $cityErr = "Only letters, numbers and white space allowed"; 
    }
  }
  if (empty($_POST["eventdate"])) {
    $eventdateErr = "Event Date is required";
  } else {
    $eventdate = test_input($_POST["eventdate"]);
    // check if name only contains letters and whitespace 
  }
  if (empty($_POST["servicestart"])) {
    $servicestartErr = "Service Start is required";
  } else {
    $servicestart = test_input($_POST["servicestart"]);
    // check if name only contains letters and whitespace 
  }
  if (empty($_POST["serviceend"])) {
    $serviceendErr = "Service End is required";
  } else {
    $serviceend = test_input($_POST["serviceend"]);
    // check if name only contains letters and whitespace 
  }
  if (empty($_POST["eventtype"])) {
    $eventtypeErr = "Event Type is required";
  } else {
    $eventtype = test_input($_POST["eventtype"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z 0-9]*$/",$eventtype)) {
      $eventtypeErr = "Only numerical value allowed"; 
    }
  }
  if (empty($_POST["numberofpax"])) {
    $numberofpaxErr = "Number of pax is required";
  } else {
    $numberofpax = test_input($_POST["numberofpax"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[0-9 ]*$/",$numberofpax)) {
      $numberofpaxErr = "Only numerical value allowed"; 
    }
  }
  if (empty($_POST["venue"])) {
    $venueErr = "Venue is required";
  } else {
    $venue = test_input($_POST["venue"]);
    // check if name only contains letters and whitespace
   
  }
  if (empty($_POST["motif"])) {
    $motifErr = "Motif is required";
  } else {
    $motif = test_input($_POST["motif"]);
    // check if name only contains letters and whitespace
  }
if(!empty($_POST['lastname']&&$_POST['firstname']&&$_POST['contactno']&&$_POST['birthdate']&&$_POST['lotno']&&$_POST['street']&&$_POST['barangay']&&$_POST['city']&&$_POST['eventdate']&&$_POST['servicestart']&&$_POST['serviceend']&&$_POST['eventtype']&&$_POST['numberofpax']&&$_POST['venue']&&$_POST['motif']))
{
  $data = getPosts();
    $insert_Query = "INSERT INTO `reservationlist` (`rsv_id`, `eventtype`, `datereserved`, `eventdate`, `setup_time`, `service_end`, `pax`, `venue`, `motif`, `username`) VALUES ('', '$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$data[5]', '$data[6]', '$data[7]', '$data[8]');";
    
   try
    {
        $insert_Result = mysqli_query($connect, $insert_Query);
        if($insert_Result)
        {
            if(mysqli_affected_rows($connect) > 0)
            {
              
            
               
            }
        
            else
            {
                 echo "<script>alert('Reservation Failed!');document.location='index.php'</script>";
            }
        }
       
    }catch(Exception $ex)
    {
        echo 'Error Insert'.$ex->getMessage();
    }

    $datas = getCustomerInfo();
    $insert_Query = "INSERT INTO `customerinfo` (`c_id`, `c_fname`, `c_lname`, `contno`, `birthday`, `lotno`, `streetno`, `barangay`, `city`,`datereserved`, `username`) VALUES (NULL, '$datas[0]', '$datas[1]', '$datas[2]', '$datas[3]', '$datas[4]', '$datas[5]', '$datas[6]', '$datas[7]', '$datas[8]','$datas[9]');
";
    
   try
    {
        $insert_Result = mysqli_query($connect, $insert_Query);
        if($insert_Result)
        {
            if(mysqli_affected_rows($connect) > 0)
            {
              
              echo "<script>alert('Reservation Success!');openCity(event, 'Package');</script>";
               
            }
        
            else
            {
                 echo "<script>alert('Reservation Failed!');document.location='index.php'</script>";
            }
        }
       
    }catch(Exception $ex)
    {
        echo 'Error Insert'.$ex->getMessage();
    }

}

  

}//end of $_SERVER
function openPax()
{
  if (confirm("Proceed to Package") == true) {
        openCity(event, 'Package');
    }
}

function getCustomerInfo()
{
  if(isset($_SESSION['username'])){
  $user = $_SESSION['username'];
}
date_default_timezone_set("Asia/Bangkok");
    $posts = array();
    $posts[0]= $_POST['firstname'];
    $posts[1]=  $_POST['lastname'];
    $posts[2]= $_POST['contactno'];
    $posts[3]= $_POST['birthdate'];
    $posts[4]= $_POST['lotno'];
    $posts[5]= $_POST['street'];
    $posts[6]= $_POST['barangay'];
    $posts[7]= $_POST['city'];
    $posts[8] = $datereserved = date("Y-m-d");
    $posts[9]= $user;
    return $posts;
}

function getPosts()
{
  if(isset($_SESSION['username'])){
  $user = $_SESSION['username'];
}
date_default_timezone_set("Asia/Bangkok");
    $posts = array();
    $posts[0]= $_POST['eventtype'];
    $posts[1]=  $datereserved = date("Y-m-d");
    $posts[2]= $_POST['eventdate'];
    $posts[3]= $_POST['servicestart'];
    $posts[4]= $_POST['serviceend'];
    $posts[5]= $_POST['numberofpax'];
    $posts[6]= $_POST['motif'];
    $posts[7]= $_POST['venue'];
    $posts[8]= $user;
    return $posts;
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!DOCTYPE HTML>  
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/reservation-style.css">
<link rel="stylesheet" type="text/css" href="css/header-center.css">
  <link rel="stylesheet" type="text/css" href="reservation/css/packageForm.css">
 <script src="js/jquery-3.1.1.js"></script>
    
<!-- write script to toggle class on scroll -->
    <script src="js/custom.js"></script>

    <script src="jquery/jquery.min.js" type="text/javascript"></script>
    <script src="jquery/jquery-ui.min.js" type="text/javascript"></script>
    <link href="jquery/jquery-ui.css" rel="Stylesheet" type="text/css" />
    <script type="text/javascript">
  $(function () {
            $('#bDate').datepicker({
                dateFormat: "yy-mm-dd",
                maxDate: -6575, 
                changeMonth: true,
                changeYear: true
            });
            $('#eDate').datepicker({
                dateFormat: "yy-mm-dd",
                minDate: 7,
                changeMonth: true,
                changeYear: true
            });
        });

  function fetch_select(val)
{
 $.ajax({
 type: 'post',
 url: 'reservation/fetch_data.php',
 data: {
  get_option:val
 },
 success: function (response) {
  document.getElementById("new_select").innerHTML=response; 
 }
 });
}
function fetch_optional(val)
{
 $.ajax({
 type: 'post',
 url: 'reservation/fetch_optional.php',
 data: {
  get_optional:val
 },
 success: function (response) {
  document.getElementById("new_optional").innerHTML=response; 
 }
 });
}
function fetch_opt_details(val)
{
 $.ajax({
 type: 'post',
 url: 'reservation/fetch_opt_details.php',
 data: {
  get_opt_details:val
 },
 success: function (response) {
  document.getElementById("new_opt_details").innerHTML=response; 
 }
 });
}
function checkLength(el){
                 
                 if(el.value.length != 11){
                    alert("Length must be exactly 11 numbers");
                    contact_error.textContent = "Contact number is required";
                    contact.style.border="1px solid red";
                    contact.focus();
                    return false;
                }
            }
function myFunction() {
    var x = document.getElementById("myNumber").value;
    var value = parseInt(x);
    $numberofpax = value;

    document.getElementById("paxno-txt").innerHTML = $numberofpax;
}


</script>



</head>
<body>  

<div class="content-reservation">
 <h1 class="big-title">- Reservation -</h1>
    <hr width="900"></hr>
  <ul class="tab">
  <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'Customer_Info')">Customer Info</a></li>
  <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'Package')" id="defaultOpen" >Package</a></li>
  <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'Payment')">Payment</a></li>
</ul>




  <div id="Customer_Info" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">x</span>
  <div class="reservation-box">

 

    <p id="note"><span class="error">* required field.</span></p>
<h2 class="reserve-label">- CUSTOMER INFORMATION -</h2>
<hr width="900"></hr>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <label id="firstname1">First Name: </label><input type="text" name="firstname" class="tField" value="<?php echo $firstname;?>">
  <span class="error">* <?php echo $firstNameErr;?></span>
  <br><br>
  <label id="lastname1">Last Name: </label><input type="text" name="lastname" class="tField" value="<?php echo $lastname;?>">
  <span class="error">* <?php echo $lastnameErr;?></span>
  <br><br>
  <label id="contact1">Contact No: </label><input type="text" onblur="checkLength(this)" name="contactno" class="tField" value="<?php echo $contactno;?>">
  <span class="error">* <?php echo $contactnoErr;?></span>
  <br><br>
  <label id="birthdate">Birthdate: </label><input type="text" id="bDate" name="birthdate" class="tField" value="<?php echo $birthdate;?>">
  <span class="error">* <?php echo $birthdateErr;?></span>
  <br><br>
  <label id="number1">Lot No/Bldg No: </label><input type="text" name="lotno" class="tField" value="<?php echo $lotno;?>">
  <span class="error">* <?php echo $lotnoErr;?></span>
  <br><br>
  <label id="street1">Street: </label><input type="text" name="street" class="tField" value="<?php echo $street;?>">
  <span class="error">* <?php echo $streetErr;?></span>
  <br><br>
  <label id="barangay1">Barangay: </label><input type="text" name="barangay" class="tField" value="<?php echo $barangay;?>">
  <span class="error">* <?php echo $barangayErr;?></span>
  <br><br>
  <label id="city1">City: </label><input type="text" name="city" class="tField" value="<?php echo $city;?>">
  <span class="error">* <?php echo $cityErr;?></span>
  <br><br>
  <h2 class="reserve-label">- EVENT INFORMATION -</h2>
  <hr width="900"></hr>
  <label id="date1">Event Date: </label><input type="text" id="eDate" name="eventdate" class="tField" value="<?php echo $eventdate;?>">
  <span class="error">* <?php echo $eventdateErr;?></span>
  <br><br>
  <label id="time">Service Start: </label><select name="servicestart" id="menu" value="<?php echo $servicestart?>">
    <option value=""></option>
                                <option value="00:00">12:00 AM</option>
                                <option value="00:30am">12:30 AM</option>
                                <option value="01:00am">1:00 AM</option>
                                <option value="01:30am">1:30 AM</option>
                                <option value="02:00am">2:00 AM</option>
                                <option value="02:30am">2:30 AM</option>
                                <option value="03:00am">3:00 AM</option>
                                <option value="03:30am">3:30 AM</option>
                                <option value="04:00am">4:00 AM</option>
                                <option value="04:30am">4:30 AM</option>
                                <option value="05:00am">5:00 AM</option>
                                <option value="05:30am">5:30 AM</option>
                                <option value="06:00am">6:00 AM</option>
                                <option value="06:30am">6:30 AM</option>
                                <option value="07:00am">7:00 AM</option>
                                <option value="07:30am">7:30 AM</option>
                                <option value="08:00am">8:00 AM</option>
                                <option value="08:30am">8:30 AM</option>
                                <option value="09:00am">9:00 AM</option>
                                <option value="09:30am">9:30 AM</option>
                                <option value="10:00am">10:00 AM</option>
                                <option value="10:30am">10:30 AM</option>
                                <option value="11:00am">11:00 AM</option>
                                <option value="11:30am">11:30 AM</option>
                                
                                <option value="12:00pm">12:00 PM</option>
                                <option value="12:30pm">12:30 PM</option>
                                <option value="13:00pm">1:00 PM</option>
                                <option value="13:30pm">1:30 PM</option>
                                <option value="14:00pm">2:00 PM</option>
                                <option value="14:30pm">2:30 PM</option>
                                <option value="15:00pm">3:00 PM</option>
                                <option value="15:30pm">3:30 PM</option>
                                <option value="16:00pm">4:00 PM</option>
                                <option value="16:30pm">4:30 PM</option>
                                <option value="17:00pm">5:00 PM</option>
                                <option value="17:30pm">5:30 PM</option>
                                <option value="18:00pm">6:00 PM</option>
                                <option value="18:30pm">6:30 PM</option>
                                <option value="19:00pm">7:00 PM</option>
                                <option value="19:30pm">7:30 PM</option>
                                <option value="20:00pm">8:00 PM</option>
                                <option value="20:30pm">8:30 PM</option>
                                <option value="21:00pm">9:00 PM</option>
                                <option value="21:30pm">9:30 PM</option>
                                <option value="22:00pm">10:00 PM</option>
                                <option value="22:30pm">10:30 PM</option>
                                <option value="23:00pm">11:00 PM</option>
                                <option value="23:30pm">11:30 PM</option>
  </select>
  <span class="error">* <?php echo $servicestartErr;?></span>
  <br><br>
   <label id="timeend">Service End: </label><select name="serviceend" id="menu" value="<?php echo $serviceend?>">
    <option value=""></option>
    <option value="00:00">12:00 AM</option>
                                <option value="00:30am">12:30 AM</option>
                                <option value="01:00am">1:00 AM</option>
                                <option value="01:30am">1:30 AM</option>
                                <option value="02:00am">2:00 AM</option>
                                <option value="02:30am">2:30 AM</option>
                                <option value="03:00am">3:00 AM</option>
                                <option value="03:30am">3:30 AM</option>
                                <option value="04:00am">4:00 AM</option>
                                <option value="04:30am">4:30 AM</option>
                                <option value="05:00am">5:00 AM</option>
                                <option value="05:30am">5:30 AM</option>
                                <option value="06:00am">6:00 AM</option>
                                <option value="06:30am">6:30 AM</option>
                                <option value="07:00am">7:00 AM</option>
                                <option value="07:30am">7:30 AM</option>
                                <option value="08:00am">8:00 AM</option>
                                <option value="08:30am">8:30 AM</option>
                                <option value="09:00am">9:00 AM</option>
                                <option value="09:30am">9:30 AM</option>
                                <option value="10:00am">10:00 AM</option>
                                <option value="10:30am">10:30 AM</option>
                                <option value="11:00am">11:00 AM</option>
                                <option value="11:30am">11:30 AM</option>
                                
                                <option value="12:00pm">12:00 PM</option>
                                <option value="12:30pm">12:30 PM</option>
                                <option value="13:00pm">1:00 PM</option>
                                <option value="13:30pm">1:30 PM</option>
                                <option value="14:00pm">2:00 PM</option>
                                <option value="14:30pm">2:30 PM</option>
                                <option value="15:00pm">3:00 PM</option>
                                <option value="15:30pm">3:30 PM</option>
                                <option value="16:00pm">4:00 PM</option>
                                <option value="16:30pm">4:30 PM</option>
                                <option value="17:00pm">5:00 PM</option>
                                <option value="17:30pm">5:30 PM</option>
                                <option value="18:00pm">6:00 PM</option>
                                <option value="18:30pm">6:30 PM</option>
                                <option value="19:00pm">7:00 PM</option>
                                <option value="19:30pm">7:30 PM</option>
                                <option value="20:00pm">8:00 PM</option>
                                <option value="20:30pm">8:30 PM</option>
                                <option value="21:00pm">9:00 PM</option>
                                <option value="21:30pm">9:30 PM</option>
                                <option value="22:00pm">10:00 PM</option>
                                <option value="22:30pm">10:30 PM</option>
                                <option value="23:00pm">11:00 PM</option>
                                <option value="23:30pm">11:30 PM</option>
                                </select>
  <span class="error">* <?php echo $serviceendErr;?></span>
  <br><br>
  <label id="eventType1">Event Type: </label><select name="eventtype" id="menu" value="<?php echo $eventtype;?>">
  <option value="default">-- Select Event Type --</option>
  <option value=""></option>
  <?php while($row1 = mysqli_fetch_array($result1)):;?>
                                <option value="<?php echo $row1[1];?>"><?php echo $row1[1];?></option>
                                    <?php endwhile;?>
                                <option>Others</option>
                            </select>
  <span class="error">* <?php echo $eventtypeErr;?></span>
  <br><br>
  <label id="pax1">Number of Pax: </label><input type="number" id="myNumber" onclick="myFunction()" min="50" class="tField" name="numberofpax" value="<?php echo $numberofpax;?>">
  <span class="error">* <?php echo $numberofpaxErr;?></span>
  <br><br>
  <label id="venue1">Venue: </label><input type="text" name="venue" class="tField" value="<?php echo $venue;?>">
  <span class="error">* <?php echo $venueErr;?></span>
  <br><br>
  <label id="motif1">Motif: </label><input type="text" name="motif" class="tField" value="<?php echo $motif;?>">
  <span class="error">* <?php echo $motifErr;?></span>
  <br><br>
  <input type="submit" class="btn" name="submit" value="Submit">

</form>

</div>
</div><!--End of Reservation -->

<div id="Package" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">x</span>


<label id= "text">Menu Package</label>
<select id= "single" onchange="fetch_select(this.value);">
  <option>--Select menu package--</option>
  <?php
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');

  $select=mysql_query("SELECT pkg_name from package");
  while($row=mysql_fetch_array($select))
  {
   echo "<option value=".$row['pkg_name'].">".$row['pkg_name']."</option>";
  
  }
 ?>
 </select>
<script>
function displayVals() {

  var singleValues = $( "#single" ).val();
  if(singleValues == "Set1A" || singleValues == "Set2A" || singleValues == "Set3A" || singleValues == "Set4A")
  {
    if($numberofpax <= 100)
      {
        singleValues = 290;
        $packageprice=singleValues;
        $total = $packageprice * $numberofpax;
        $counter = $total;
        $count = $counter;
        $( "#pax-txt" ).html( singleValues );
        $( "#total-txt" ).html( $total );
        var temp = $optional;
        if(temp != 0)
          $total = $total + temp;
        
        $( "#total-txt" ).html( $total );

      }else{
        singleValues = 41500;
        $add = 290*($numberofpax - 100);
        $packageprice = 41500 + $add; 
        $total = $packageprice;
        $counter = $total;
        $count = $counter;
        $( "#pax-txt" ).html( singleValues );
        $( "#total-txt" ).html( $total );
        var temp = $optional;
        if(temp != 0)
          $total = $total + temp;
        
        $( "#total-txt" ).html( $total );

      }
  }
  if(singleValues == "Set1B" || singleValues == "Set2B" || singleValues == "Set3B" || singleValues == "Set4B")
  {
    if($numberofpax <= 100)
      {
        singleValues = 340;
        $packageprice=singleValues;
        $total = $packageprice * $numberofpax;
        $counter = $total;
        $count = $counter;
        $( "#pax-txt" ).html( singleValues );
        $( "#total-txt" ).html( $total );
        var temp = $optional;
        if(temp != 0)
          $total = $total + temp;
        
        $( "#total-txt" ).html( $total );

      }else{
        singleValues = 45000;
        $add = 320*($numberofpax - 100);
        $packageprice = 45000 + $add; 
        $total = $packageprice;
        $counter = $total;
        $count = $counter;
       $( "#pax-txt" ).html( singleValues );
        $( "#total-txt" ).html( $total );
        var temp = $optional;
        if(temp != 0)
          $total = $total + temp;
        
        $( "#total-txt" ).html( $total );
      }
  }

}

$( "#single" ).change( displayVals );
displayVals();

</script>
<div class="price-box">
  <p class="total-pax"><strong>No of Guests: </strong></p> <p class="pax-txt" id="paxno-txt"></p>
  <p class="total-pax-price"><strong>Price per Guests: </strong></p> <p class="pax-price" id="pax-txt"></p>
  <p class="total-adds"><strong>Additional: </strong></p>
   <p id="optional-txt1"></p>
   <p id="optional-txt2"></p>
   <p id="optional-txt3"></p>
   <p id="optional-txt4"></p>
  <p class="total-"><strong>Total: </strong></p> <p class="total-p" id="total-txt"></p>
</div>

    <div class="box-pax">
      <table class="tbl-head" cellpadding="10" cellspacing="1">
      <tbody>
      <tr>
      <th><strong>Name</strong></th>
      <th><strong>Type</strong></th>
      </tr> 
      </tbody>
      </table>
      <table id="new_select" cellpadding="10" cellspacing="1">
      <!-- Fetch_data.php values insert here -->
      <tbody>   
      </tbody>
      </table>
</div>


<label id= "text">Optional</label>


<div class="box-pax-optional">

      <table class="tbl-head" cellpadding="10" cellspacing="1">
      <tbody>
      <tr>
      <th><strong>Option</strong></th>
      <th><strong>Name</strong></th>
      <th><strong>Details</strong></th>
      <th><strong>Price</strong></th>
      </tr>
      </tbody>
      </table> 
      <table id="new_select" cellpadding="10" cellspacing="1">
      <tbody>
      <?php
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');
  $option =1;
  $query=mysql_query("SELECT * from tbl_optional");
  while($row=mysql_fetch_array($query))
  {
      
   echo "<tr><td>"."Option ". $option."</td>";
   echo "<td>".$row['op_name']."</td>";
   echo "<td>".$row['op_details']."</td>";
   echo "<td>".$row['op_price']." per head"."</td></tr>";
    $option++;
  }
 ?>
      </tbody>
      </table>
<label>Option 1<input type="checkbox" name="selectedItems1" value="75" /></label>
<label>Option 2<input type="checkbox" name="selectedItems2" value="75" /></label>
<label>Option 3<input type="checkbox" name="selectedItems3" value="85" /></label>
<label>Option 4<input type="checkbox" name="selectedItems4" value="85" /></label>

</div>
<script type="text/javascript">
  $('input[name="selectedItems1"]').click(function(){ 
  if (this.checked) {
    if($total > $counter)
      {
        $total = $counter;
      }
    var d1 = this.value;
    $optional1 = parseInt(d1);
    
    $( "#optional-txt1" ).html("Option1 " + $optional1 );
    $total = $total + $optional1;
    $count = $total;
      $( "#total-txt" ).html( $total ); 
  }else{
    $total = $count - $optional1;
    $count = $total;
     $( "#total-txt" ).html( $total );
    $optional1 = "";
$( "#optional-txt1" ).html( $optional1 );
     
  }
});
  $('input[name="selectedItems2"]').click(function(){ 
  if (this.checked) {
    if($total > $counter)
      {
        $total = $counter;
      }
    var d2 = this.value;
    $optional2 = parseInt(d2);
    $( "#optional-txt2" ).html("Option2 " + $optional2 );
    $total = $count + $optional2;
    $count = $total;
      $( "#total-txt" ).html( $total ); 
  }else{
    $total = $count - $optional2;
    $count = $total;
     $( "#total-txt" ).html( $total );
    $optional2 = "";
$( "#optional-txt2" ).html( $optional2 );
     
  }
});
  $('input[name="selectedItems3"]').click(function(){ 
  if (this.checked) {
    if($total > $counter)
      {
        $total = $counter;
      }
    var d3 = this.value;
    $optional3 = parseInt(d3);
    $( "#optional-txt3" ).html("Option3 " + $optional3 );
    $total = $count + $optional3;
    $count = $total;
      $( "#total-txt" ).html( $total ); 
  }else{
    $total = $count - $optional3;
    $count = $total;
     $( "#total-txt" ).html( $total );
    $optional3 = "";
$( "#optional-txt3" ).html( $optional3 );
     
  }
});
  $('input[name="selectedItems4"]').click(function(){ 
  if (this.checked) {
    if($total > $counter)
      {
        $total = $counter;
      }
    var d4 = this.value;
    $optional4 = parseInt(d4);
    $( "#optional-txt4" ).html("Option4 " + $optional4 );
    $total = $count + $optional4;
    $count = $total;
      $( "#total-txt" ).html( $total ); 
  }else{
    $total = $count - $optional4;
    $count = $total;
     $( "#total-txt" ).html( $total );
    $optional4 = "";
$( "#optional-txt4" ).html( $optional4 );
     
  }
});
</script>

</div><!-- END of Package-->
<div id="Payment" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">x</span>
  <h3>Payment</h3>
  <p>It's Free! :)</p>


</div>

</div><!--End of Content -->

</body>
</html>
<script>
function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
