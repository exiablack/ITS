<?php include_once('reservation/packageForm.php');
$hostname = "localhost";
$username = "root";
$password = "";
$databaseName = "senordepacencia";

$lastname = "";
$firstname = "";
$contact= "";
$birthdate = "";

$lotno = "";
$street = "";
$barangay = "";
$city ="";
$eventdate = "";
$starttime = "";
$endtime="";
$pax = "";
$venue = "";
$motif = "";
$menu = "";

$otherevent="";

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
/*function getPosts()
{
    $posts = array();
  
    $posts[0] = $_POST['lastname'];
    $posts[1] = $_POST['firstname'];
    $posts[2] = $_POST['middlename'];
    $posts[3] = $_POST['contact'];
        $posts[4] = $_POST['birthdate'];
      
        $posts[5] = $_POST['lotno'];
        $posts[6] = $_POST['street'];
        $posts[7] = $_POST['barangay'];
        $posts[8] = $_POST['city'];
        
    $posts[9] = $_POST['date1'];
    $posts[10] = $_POST['starttime'];
    $posts[11] = $_POST['eventtype'];
    $posts[12] = $_POST['otherevent'];
    $posts[13] = $_POST['pax'];
    $posts[14] = $_POST['venue'];
        $posts[15] = $_POST['theme'];
        
        $posts[16] = $_POST['motif'];
        $posts[17] = $_POST['menu'];
      
    
    return $posts;
}

//insert
if(isset($_POST['insert']))
{
    $data = getPosts();
    $insert_Query = "INSERT INTO `tbl_online`(`lastname`, `firstname`, `middlename`, `contact`, `birthdate`, `lotno`, `street`, `barangay`, `city`, `date1`, `starttime`, `eventtype`, `otherevent`, `pax`, `venue`, `theme`, `motif`, `menu`) VALUES
('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]', '$data[5]','$data[6]','$data[7]','$data[8]','$data[9]','$data[10]', '$data[11]','$data[12]','$data[13]','$data[14]','$data[15]','$data[16]','$data[17]')";
    
   try
    {
        $insert_Result = mysqli_query($connect, $insert_Query);
        if($insert_Result)
        {
            if(mysqli_affected_rows($connect) > 0)
            {
              
             //  header("refresh:2; index.php");
        // echo 'Data Inserted';'
                

           echo "<script>alert('Reservation Successful!');document.location='index.php'</script>";


               
            }
        
            else
            {
                echo 'Data Not Inserted';
            }
        }
       
    }catch(Exception $ex)
    {
        echo 'Error Insert'.$ex->getMessage();
    }
}
*/
 ?>
<html>
<head>
    <title>Online Reservation</title>
    <link rel="stylesheet" type="text/css" href="css/reservationV2.css"/>
  <link rel="stylesheet" type="text/css" href="reservation/css/packageForm.css">
      <script src="js/jquery-3.1.1.js"></script>
    
<!-- write script to toggle class on scroll -->
    <script src="js/custom.js"></script>

    <script src="jquery/jquery.min.js" type="text/javascript"></script>
    <script src="jquery/jquery-ui.min.js" type="text/javascript"></script>
    <link href="jquery/jquery-ui.css" rel="Stylesheet" type="text/css" />
<script type="text/javascript">
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

</script>
<script type="text/javascript">
        $(function () {
            $('#txtDate1').datepicker({
                dateFormat: "yy-mm-dd",
                maxDate: -6575, 
                changeMonth: true,
                changeYear: true
            });
            $('#txtDate2').datepicker({
                dateFormat: "yy-mm-dd",
                minDate: 7,
                changeMonth: true,
                changeYear: true
            });
        });
        function capitalize(textboxid, str) {
          // string with alteast one character
         if (str && str.length >= 1){       
             var firstChar = str.charAt(0);
             var remainingStr = str.slice(1);
             str = firstChar.toUpperCase() + remainingStr;
         }
         document.getElementById(textboxid).value = str;
     }
     
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
        return true;
    }
    
    function myFunction(){
                     alert("Request Sent! Thank you for the inquire");
                     
               }
               
               // validate birthday
function validateAge($birthday, $age = 18)
{
    // $birthday can be UNIX_TIMESTAMP or just a string-date.
    if(is_string($date1)) {
        $date1 = strtotime($birthday);
    }

    // check
    // 31536000 is the number of seconds in a 365 days year.
    if(time() - $date1< $age * 31536000)  {
        alert("Your age is not valid");
        return false;
    }

    return true;
}
    </script>
</head>
<body>
        <?php
            include('nav-banner.php');
        ?>
    <div class="content-reservation">
        <h1 class="big-title">- Reservation -</h1>
        <hr width="900"></hr>
        
        <ul class="tab">
  <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'Customer_Info')" id="defaultOpen">Customer Info</a></li>
  <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'Package')">Package</a></li>
  <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'Payment')">Payment</a></li>
</ul>


 
<div id="Customer_Info" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">x</span>
    <div class="reservation-box">
        <p id= "note">Legend: Fields with  (<span><img src= "resources/star.png"/></span>) are required</p>
        <br><br>
        <div class="label">
    <form action="" method="POST" onsubmit="return Validate()" name="vForm">
        
                            <h2 class="reserve-label">- EVENT INFORMATION -</h2>
        <hr width="900"></hr>
        <label id= "date1">Date</label>
        <input type="text" id="txtDate2" name="eventdate" placeholder="Date of Event *" class="tField" value="<?php echo $eventdate;?>">
                            <span><img src="resources/star.png"/></span><div id="eventdate_error" class="val_error"></div>
                            <br>


        <label id= "eventType1">Event Type</label>
        <select class= "eventtype" id= "eventtype" name="eventtype" value="<?php echo $eventtype;?>" onsubmit="return Validate()" onchange="enabledisabletext()">
                            
                                <span><img src="resources/star.png"/></span><div id="eventtype_error" class="val_error"></div>
                                <br>

         <option disabled>--Select Event Type--</option>
                                <option></option>
                               <?php while($row1 = mysqli_fetch_array($result1)):;?>
                                <option value="<?php echo $row1[1];?>"><?php echo $row1[1];?></option>
                                    <?php endwhile;?>
                                <option>Others</option>
                            </select>
                            
        <input type= "text" id= "otherevent" name="otherevent" placeholder="Other Event *" class="tField" onkeyup="javascript:capitalize(this.id, this.value);">
                            
                            <span><img src="resources/star.png"/></span><div  class="val_error"></div>
                            <br>

        <label id= "pax1">Number of pax</label>
        <input type= "number" id= "pax" name="pax" placeholder="Number of pax *" class="tField" onkeypress="return isNumberKey(event)" min="50">

                            <span><img src="resources/star.png"/></span><div id="pax_error" class="val_error"></div>
                            <br>

        <label id= "venue1">Venue</label>
        <input type= "text" id= "venue" name="venue" placeholder="Place of Event *" class="tField" value="<?php echo $venue;?>" onkeyup="javascript:capitalize(this.id, this.value);">
                            <span><img src="resources/star.png"/></span><div id="venue_error" class="val_error"></div>
                            <br>
        <label id= "motif1">Motif</label>
        <input type= "text" id= "motif" name="motif" placeholder="Event motif *" class="tField" value="<?php echo $motif;?>" onkeyup="javascript:capitalize(this.id, this.value);">
                            
                            <span><img src="resources/star.png"/></span><div id="motif_error" class="val_error"></div>
                            <br>

  <input type="submit" name="insert" id="insert" onclick="openCity(event, 'Package')" value="Proceed to Package ->" class="btn">

                            </form>

                            </div>
                            </div>
</div><!--End of Customer Info -->

<div id="Package" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">x</span>


<label id= "text">Menu Package</label>
<select id= "menu" onchange="fetch_select(this.value);">
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
   echo "<option>".$row['pkg_name']."</option>";
  }
 ?>
 </select>

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

</div><!-- END of Package-->

<div id="Payment" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">x</span>
  <h3>Payment</h3>
  <p>It's Free! :)</p>
</div>
        
    </div><!-- END of CONTENT -->

        <!-- Footer PHP FILE -->


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

<script language="javascript">
function enabledisabletext()
{
    if(document.vForm.eventtype.value=='<?php echo $row1[0];?>')
    {
    document.vForm.otherevent.disabled=true;
    
    }
    else{
        document.vForm.otherevent.disabled=false;
        
    }
    
}

    // GETTING ALL INPUT TEXT FIELDS
   
        
        var eventdate = document.forms["vForm"]["eventdate"];

        var eventtype = document.forms["vForm"]["eventtype"];
        var pax = document.forms["vForm"]["pax"];
        var venue = document.forms["vForm"]["venue"];
        var motif = document.forms["vForm"]["motif"];
        

    // GETTING ALL ERROR OBJECTS
   
        
        var eventdate_error = document.getElementById("eventdate_error");

        var eventtype = document.forms["vForm"]["menu"];
        var pax_error = document.getElementById("pax_error");
        var venue_error = document.getElementById("venue_error");
        var motif_error = document.getElementById("motif_error");
    

    // SETTING ALL EVENT LISTENERS
   
        
        eventdate.addEventListener("blur", eventdateVerify, true);

        pax.addEventListener("blur", paxVerify, true);
        venue.addEventListener("blur", venueVerify, true);
        motif.addEventListener("blur", motifVerify, true);
        eventtype.addEventListener("blur", eventtypeVerify, true);
                        
                function Validate(){
     
    
                // VALIDATE DATE
        if(eventdate.value == ""){
            eventdate_error.textContent = "*Date is required";
            eventdate.style.border = "1px solid red";
            openCity(event, 'Customer_Info');
            eventdate.focus();
            return false;
        }
    
  

                // VALIDATE PAX
        if(pax.value == ""){
            pax_error.textContent = "*Pax is required";
            pax.style.border = "1px solid red";
            openCity(event, 'Customer_Info');
            pax.focus();
            return false;
        }
                // VALIDATE VENUE
        if(venue.value == ""){
            venue_error.textContent = "*Venue is required";
            venue.style.border = "1px solid red";
            openCity(event, 'Customer_Info');
            venue.focus();
            return false;
        }

          // VALIDATE MOTIF
        if(motif.value == ""){
            motif_error.textContent = "*Motif is required";
            motif.style.border = "1px solid red";
            openCity(event, 'Customer_Info');
            motif.focus();
            return false;
        } else if(motif.value!=""){
            openCity(event, 'Package');
            return false;
        }

    }

    // ADD EVENT LISTENERS
    
        
         function eventdateVerify(){
        if (eventdate.value != "") {
            eventdate_error.innerHTML = "";
            eventdate.style.border = "1px solid #110E0F";
            return true;
        }
    }
        function starttimeVerify(){
        if (starttime.value != "") {
            starttime_error.innerHTML = "";
            starttime.style.border = "1px solid #110E0F";
            return true;
        }
    }
        
         function starttimeVerify(){
        if(document.getElementsByName("starttime")[0].selectedIndex==0){
                    alert("Please select StartTime from the list");
                    return false;
                }
                return true
    }
    function endtimeVerify(){
        if(document.getElementsByName("endtime")[0].selectedIndex==0){
                    alert("Please select EndTime from the list");
                    return false;
                }
                return true
    }
         function eventtypeVerify(){
        if(document.getElementsByName("eventtype")[0].selectedIndex==0){
                    alert("Please select Event type from the list");
                    return false;
                }
                return true
    }
        
        function eventtypeVerify(){
        if (eventtype.value != "") {
            eventtype_error.innerHTML = "";
            eventtype.style.border = "1px solid #110E0F";
            return true;
        }
    }
         function paxVerify(){
        if (pax.value != "") {
            pax_error.innerHTML = "";
            pax.style.border = "1px solid #110E0F";
            return true;
        }
    }
         function venueVerify(){
        if (venue.value != "") {
            venue_error.innerHTML = "";
            venue.style.border = "1px solid #110E0F";
            return true;
        }
    }
        function motifVerify(){
        if (motif.value != "") {
            motif_error.innerHTML = "";
            motif.style.border = "1px solid #110E0F";
            return true;
        }
    }

</script>