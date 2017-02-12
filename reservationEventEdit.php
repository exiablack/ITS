<?php
  session_start();
$hostname = "localhost";
$username = "root";
$password = "";
$databaseName = "senordepacencia";
// define variables and set to empty values

$eventdateErr="";
$servicestartErr="";
$serviceendErr="";
$eventtypeErr="";
$numberofpaxErr="";
$venueErr="";
$motifErr="";

$phpArray = array();
$datereserved = date("Y-m-d");
$eventdate="";
$servicestart="";
$serviceend="";
$eventtype="";
$otherevent="";
$numberofpax="";
$venue="";
$motif="";

$packageprice=0;
$optional="";

$maxDate="";
$GET_TOTAL_Q="";
$session_rsv="";
$pkgrsv_id="";
$pkgrsv_package="";
$pax_price="";
$op[1]="";
$op[2]="";
$op[3]="";
$op[4]="";
$opAdd[1]="";
$opAdd[2]="";
$opAdd[3]="";
$opAdd[4]="";
$new_total="";
$op_price[1]="";
$op_price[2]="";
$op_price[3]="";
$op_price[4]="";
$TOTAL_Q="";
$PAX_Q="";

if(isset($_SESSION['username'])){
  $account = $_SESSION['username'];
}
if(isset($_SESSION['rsv_id'])){
  $session_rsv = $_SESSION['rsv_id'];
}
$connect = mysqli_connect($hostname, $username, $password, $databaseName);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try{
    $connect = mysqli_connect($hostname, $username, $password, $databaseName);
    
}catch(Exception $ex)
{
    echo 'Error';
}

$queryDate = "SELECT max_date FROM maintenance";

$result1 = mysqli_query($connect, $queryDate);
while ($row1 = mysqli_fetch_array($result1)) {
  $maxDate = $row1["max_date"];
}

$query = "SELECT * FROM eventtype";
$load = "SELECT * FROM reservationlist WHERE rsv_id='$session_rsv'";
$updateQ = "SELECT pkg_name, pkgrsv_id, total, op1, op2, op3, op4 FROM packagereserve WHERE username='$account' && paymentstatus='unpaid'";

$result1 = mysqli_query($connect, $query);
$result2 = mysqli_query($connect, $load);
$result3 = mysqli_query($connect, $updateQ);

while($row1 = mysqli_fetch_array($result2)):;
$eventdate = $row1['eventdate'];
$servicestart = $row1['setup_time'];
$serviceend = $row1['service_end'];
$eventtype = $row1['eventtype'];
$pax = $row1['pax'];
$PAX_Q=$row1['pax'];
$venue = $row1['venue'];
$motif = $row1['motif'];
endwhile;

while($row3 = mysqli_fetch_array($result3)):;
$pkgrsv_id=$row3['pkgrsv_id'];
$pkgrsv_package=$row3['pkg_name'];
$TOTAL_Q = $row3['total'];
$op[1]=$row3['op1'];
$op[2]=$row3['op2'];
$op[3]=$row3['op3'];
$op[4]=$row3['op4'];
endwhile;

$selectPax = "SELECT price_per_head FROM package WHERE pkg_name='$pkgrsv_package'";
$result4 = mysqli_query($connect, $selectPax);

while($row4 = mysqli_fetch_array($result4)):;
$pkg_price=$row4['price_per_head'];
endwhile;



for ($i=1; $i <= 4 ; $i++) {
    if($op[$i]!="none"){
        $selectOps = "SELECT op_price FROM tbl_optional WHERE op_name ='$op[$i]'";
        $result5 = mysqli_query($connect, $selectOps);

    while($row5 = mysqli_fetch_array($result5)):;

        $op_price[$i]=$row5['op_price'];
         endwhile;
    }else{
        $op_price[$i] = 0; 
    }
    

}


//------------------------------------------------ O O O

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $temps = $_POST['otherevent'];
  $tempz = $_POST['eventtype'];
    
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
  }
  if($_POST['eventtype']=="Others"&&!empty($_POST['otherevent']))
  {
    $eventtype = $_POST['otherevent'];
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
    if (!preg_match("/^[a-zA-Z 0-9 ]*$/",$venue)) {
      $venueErr = "Only letters, numbers and white space allowed"; 
    }
  }
  if (empty($_POST["motif"])) {
    $motifErr = "Motif is required";
  } else {
    $motif = test_input($_POST["motif"]);
    // check if name only contains letters and whitespace
  }

 

if(!empty($_POST['eventdate']&&$_POST['servicestart']&&$_POST['serviceend']&&$_POST['eventtype']&&$_POST['numberofpax']&&$_POST['venue']&&$_POST['motif']))
{

         $data = getPosts();

         for ($i=1; $i <= 4; $i++) { 
            if($op_price[$i] != 0)
            {
                $GET_TOTAL_Q += ($op_price[$i] * $data[5]);
            }
         }

        /* $temp_total = $PAX_Q * $pkg_price;
         $sub_total = $TOTAL_Q - $temp_total;*/

         $get_total = $pkg_price * $data[5];
         $new_total = $get_total + $GET_TOTAL_Q;

    $insert_Query = "UPDATE `reservationlist` SET `eventtype` = '$data[0]', `datereserved` = '$data[1]', `eventdate` = '$data[2]', `setup_time` = '$data[3]', `service_end` = '$data[4]', `pax` = '$data[5]', `venue` = '$data[6]', `motif` = '$data[7]' WHERE `reservationlist`.`rsv_id` = $session_rsv";

    $update_total = "UPDATE `packagereserve` SET `total` = '$new_total' WHERE `packagereserve`.`pkgrsv_id` = $pkgrsv_id";
    
   try
    {
        $insert_Result = mysqli_query($connect, $insert_Query);
        if($insert_Result)
        {
            if(mysqli_affected_rows($connect) > 0)
            {
                $updateTotal = mysqli_query($connect, $update_total);
                if($updateTotal)
                {
                    if(mysqli_affected_rows($connect) > 0)
                    {
                        echo "<script>alert('Event Information Updated!');document.location='reservationPayment.php'</script>";
                    }
                }
              
              
               
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


function getPosts()
{
  if(isset($_SESSION['username'])){
  $useraccount = $_SESSION['username'];
}
 $temp = $_POST['eventtype'];
  if($temp=="Others")
  {
    $temp = $_POST['otherevent'];
  }else{
    $temp = $_POST['eventtype'];
  }

date_default_timezone_set("Asia/Bangkok");
    $posts = array();
    $posts[0]= $temp;
    $posts[1]=  $datereserved = date("Y-m-d");
    $posts[2]= $_POST['eventdate'];
    $posts[3]= $_POST['servicestart'];
    $posts[4]= $_POST['serviceend'];
    $posts[5]= $_POST['numberofpax'];
    $posts[6]= $_POST['venue'];
    $posts[7]= $_POST['motif'];
    $posts[8]= $useraccount;
    return $posts;
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<?php
 $host = 'localhost';
  $user = 'root';
  $pass = '';
  $phpArray = array();
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');

  $select=mysql_query("SELECT eventdate, COUNT(*) FROM reservationlist GROUP BY eventdate having count(*) = $maxDate");
  while($row=mysql_fetch_array($select))
  {
    $phpArray[] = $row['eventdate'];
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
    var disableddates = <?php echo json_encode($phpArray); ?>;


function DisableSpecificDates(date) {
    var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
    return [disableddates.indexOf(string) == -1];
  }
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
                beforeShowDay: DisableSpecificDates
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


function lengthCheck(el){
                 
                 if(el.value.length != 11){
                    alert("Length must be exactly 11 numbers");
                    contact_error.textContent = "Contact number is required";
                    return false;
                }
            }
function myFunction() {
    var x = document.getElementById("myNumber").value;
    var value = parseInt(x);
    $numberofpax = value;

    document.getElementById("paxno-txt").innerHTML = $numberofpax;
}
function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
        return true;
    }

</script>



</head>
<body>  
<?php include('nav-banner.php');
?>
<div class="content-reservation">
 <h1 class="big-title">- Reservation -</h1>
    <hr width="900"></hr>
  <ul class="tab">
  <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'Customer_Info')" id="defaultOpen">Customer Info</a></li>
  <li><a href="javascript:void(0)" class="tablinks" readonly>Package</a></li>
  <li><a href="javascript:void(0)" class="tablinks" readonly>Payment</a></li>
</ul>



<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div id="Customer_Info" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">x</span>
  <div class="reservation-box">

    <p id="note"><span class="error">* required field.</span></p>

  <h2 class="reserve-label">- EVENT INFORMATION -</h2>
  <hr width="900"></hr>
  <label id="date1">Event Date: </label><input type="text" id="eDate" name="eventdate" class="tField" value="<?php echo $eventdate;?>">
  <span class="error">* <?php echo $eventdateErr;?></span>
  <br><br>
  <label id="time">Service Start: </label><select name="servicestart" id="menu" value="<?php echo $servicestart?>">
    <option value=""></option>
                                <option value="00:00:00">12:00 AM</option>
                                <option value="00:30:00">12:30 AM</option>
                                <option value="01:00:00">1:00 AM</option>
                                <option value="01:30:00">1:30 AM</option>
                                <option value="02:00:00">2:00 AM</option>
                                <option value="02:30:00">2:30 AM</option>
                                <option value="03:00:00">3:00 AM</option>
                                <option value="03:30:00">3:30 AM</option>
                                <option value="04:00:00">4:00 AM</option>
                                <option value="04:30:00">4:30 AM</option>
                                <option value="05:00:00">5:00 AM</option>
                                <option value="05:30:00">5:30 AM</option>
                                <option value="06:00:00">6:00 AM</option>
                                <option value="06:30:00">6:30 AM</option>
                                <option value="07:00:00">7:00 AM</option>
                                <option value="07:30:00">7:30 AM</option>
                                <option value="08:00:00">8:00 AM</option>
                                <option value="08:30:00">8:30 AM</option>
                                <option value="09:00:00">9:00 AM</option>
                                <option value="09:30:00">9:30 AM</option>
                                <option value="10:00:00">10:00 AM</option>
                                <option value="10:30:00">10:30 AM</option>
                                <option value="11:00:00">11:00 AM</option>
                                <option value="11:30:00">11:30 AM</option>
                                
                                <option value="12:00:00">12:00 PM</option>
                                <option value="12:30:00">12:30 PM</option>
                                <option value="13:00:00">1:00 PM</option>
                                <option value="13:30:00">1:30 PM</option>
                                <option value="14:00:00">2:00 PM</option>
                                <option value="14:30:00">2:30 PM</option>
                                <option value="15:00:00">3:00 PM</option>
                                <option value="15:30:00">3:30 PM</option>
                                <option value="16:00:00">4:00 PM</option>
                                <option value="16:30:00">4:30 PM</option>
                                <option value="17:00:00">5:00 PM</option>
                                <option value="17:30:00">5:30 PM</option>
                                <option value="18:00:00">6:00 PM</option>
                                <option value="18:30:00">6:30 PM</option>
                                <option value="19:00:00">7:00 PM</option>
                                <option value="19:30:00">7:30 PM</option>
                                <option value="20:00:00">8:00 PM</option>
                                <option value="20:30:00">8:30 PM</option>
                                <option value="21:00:00">9:00 PM</option>
                                <option value="21:30:00">9:30 PM</option>
                                <option value="22:00:00">10:00 PM</option>
                                <option value="22:30:00">10:30 PM</option>
                                <option value="23:00:00">11:00 PM</option>
                                <option value="23:30:00">11:30 PM</option>
  </select>
  <span class="error">* <?php echo $servicestartErr;?></span>
  <br><br>
   <label id="timeend">Service End: </label><select name="serviceend" id="menu" value="<?php echo $serviceend?>">
    <option value=""></option>
                                <option value="00:00:00">12:00 AM</option>
                                <option value="00:30:00">12:30 AM</option>
                                <option value="01:00:00">1:00 AM</option>
                                <option value="01:30:00">1:30 AM</option>
                                <option value="02:00:00">2:00 AM</option>
                                <option value="02:30:00">2:30 AM</option>
                                <option value="03:00:00">3:00 AM</option>
                                <option value="03:30:00">3:30 AM</option>
                                <option value="04:00:00">4:00 AM</option>
                                <option value="04:30:00">4:30 AM</option>
                                <option value="05:00:00">5:00 AM</option>
                                <option value="05:30:00">5:30 AM</option>
                                <option value="06:00:00">6:00 AM</option>
                                <option value="06:30:00">6:30 AM</option>
                                <option value="07:00:00">7:00 AM</option>
                                <option value="07:30:00">7:30 AM</option>
                                <option value="08:00:00">8:00 AM</option>
                                <option value="08:30:00">8:30 AM</option>
                                <option value="09:00:00">9:00 AM</option>
                                <option value="09:30:00">9:30 AM</option>
                                <option value="10:00:00">10:00 AM</option>
                                <option value="10:30:00">10:30 AM</option>
                                <option value="11:00:00">11:00 AM</option>
                                <option value="11:30:00">11:30 AM</option>
                                
                                <option value="12:00:00">12:00 PM</option>
                                <option value="12:30:00">12:30 PM</option>
                                <option value="13:00:00">1:00 PM</option>
                                <option value="13:30:00">1:30 PM</option>
                                <option value="14:00:00">2:00 PM</option>
                                <option value="14:30:00">2:30 PM</option>
                                <option value="15:00:00">3:00 PM</option>
                                <option value="15:30:00">3:30 PM</option>
                                <option value="16:00:00">4:00 PM</option>
                                <option value="16:30:00">4:30 PM</option>
                                <option value="17:00:00">5:00 PM</option>
                                <option value="17:30:00">5:30 PM</option>
                                <option value="18:00:00">6:00 PM</option>
                                <option value="18:30:00">6:30 PM</option>
                                <option value="19:00:00">7:00 PM</option>
                                <option value="19:30:00">7:30 PM</option>
                                <option value="20:00:00">8:00 PM</option>
                                <option value="20:30:00">8:30 PM</option>
                                <option value="21:00:00">9:00 PM</option>
                                <option value="21:30:00">9:30 PM</option>
                                <option value="22:00:00">10:00 PM</option>
                                <option value="22:30:00">10:30 PM</option>
                                <option value="23:00:00">11:00 PM</option>
                                <option value="23:30:00">11:30 PM</option>
                                </select>
  <span class="error">* <?php echo $serviceendErr;?></span>
  <br><br>
  <label id="eventType1">Event Type: </label><select name="eventtype" id="menu" value="<?php echo $eventtype;?>">
  <option value="" disabled="disabled">-- Select Event Type --</option>
  <option value=""></option>
  <?php while($row1 = mysqli_fetch_array($result1)):;?>
                                <option value="<?php echo $row1[1];?>"><?php echo $row1[1];?></option>
                                    <?php endwhile;?>
                                <option>Others</option>
                            </select>
   <input type="text" id="otherevent" class="tField" name="otherevent" placeholder="Other Event" value="<?php echo $otherevent;?>">
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
  <input type="submit" class="btn" name="submit" value="Proceed to Package">

</form>

</div>
</div><!--End of Reservation -->


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
