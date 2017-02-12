<?php
$hostname = "localhost";
$username = "root";
$password = "";
$databaseName = "senordepacencia";

$lastname = "";
$firstname = "";
$middlename = "";
$contact= "";
$birthdate = "";

$lotno = "";
$street = "";
$barangay = "";
$city ="";
$date = "";
$time1 = "";
$eventtype = "";
$pax = "";
$venue = "";
$theme = "";
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

/*$query1 = "Select a.package_name,GROUP_CONCAT(b.foodlist_name ,' ' ) from tbl_foodpackage as a INNER JOIN tbl_foodlist as b ON a.package_id = b.package_id GROUP BY(a.package_name) ";*/

$result1 = mysqli_query($connect, $query);
/*$result2 = mysqli_query($connect, $query1);*/

function getPosts()
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
    $posts[10] = $_POST['time1'];
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
    $insert_Query = "INSERT INTO `tbl_online`(`lastname`, `firstname`, `middlename`, `contact`, `birthdate`, `lotno`, `street`, `barangay`, `city`, `date1`, `time1`, `eventtype`, `otherevent`, `pax`, `venue`, `theme`, `motif`, `menu`) VALUES
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
?>

<html>
<head>
    <title>Online Reservation</title>
    <link rel="stylesheet" type="text/css" href="css/header-center.css"/>
    <link rel="stylesheet" type="text/css" href="css/reservation.css"/>
    <script src="js/jquery-3.1.1.js"></script>
    
<!-- write script to toggle class on scroll -->
    <script src="js/custom.js"></script>

    <script src="jquery/jquery.min.js" type="text/javascript"></script>
    <script src="jquery/jquery-ui.min.js" type="text/javascript"></script>
    <link href="jquery/jquery-ui.css" rel="Stylesheet" type="text/css" />

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

<?php include('nav-banner.php');
?>

    <div class="content-reservation">
        <h1 class="big-title">- Reservation -</h1>
        <hr width=" 900"></hr>
        
        <div class="reservation-box">
        <p id= "note">Legend: Fields with asterisks (<span><img src= "resources/star.png"/></span>) are required</p>
        <br><br>
        <div class="label">
    <form action="" method="POST" onsubmit="return Validate()" name="vForm">
        <h2 class="reserve-label">- CUSTOMER INFORMATION -</h2>
        <hr width="900"></hr>

        <label id= "lastname1">Last Name</label>
        <input type= "text" id= "lastname" name="lastname" pattern="[a-zA-Z]+" title="Invalid input" placeholder="Last name  *" class="tField" value="<?php echo $lastname;?>"  onkeyup="javascript:capitalize(this.id, this.value);">
                            <span><img src= "resources/star.png"/></span><div id="lastname_error" class="val_error"></div>
                            <br>

        <label id= "firstname1">First Name</label>
        <input type= "text" id= "firstname" name="firstname" placeholder="First name *" class="tField" value="<?php echo $firstname;?>"  onkeyup="javascript:capitalize(this.id, this.value);"> 
                            <span><img src= "resources/star.png"/></span><div id="firstname_error" class="val_error"></div>
                            <br>

        <label id= "middlename1">Middle Name</label>
        <input type= "text" id= "middlename" name="middlename" placeholder="Middle name (Optional)" class="tField" value="<?php echo $middlename;?>"  onkeyup="javascript:capitalize(this.id, this.value);">

                            <div class="val_error"></div>
                            <br>

        <label id= "contact1">Contact No.</label>
        <input type= "text" id= "contact" name="contact" onblur="checkLength(this)" placeholder="Contact Number *" onkeypress="return isNumberKey(event)" class="tField" value="<?php echo $contact;?>"  onkeyup="javascript:capitalize(this.id, this.value);" maxlength="11">
                            <span><img src= "resources/star.png"/></span><div id="contact_error" class="val_error"></div>
                            <br>
             <label id= "birthdate">Birthdate</label>
        <input type="text" id="txtDate1" name="birthdate" placeholder="Birthdate *" class="tField" value="<?php echo $birthdate;?>">

                            <span><img src= "resources/star.png"/></span><div id="birthdate_error" class="val_error"></div>
                            <br>
                             <label id= "number1">Lot No./Bldg No.</label>
        <input type="text" id="number" name="lotno" placeholder="Lot No./Building No. *" class="tField" value="<?php echo $lotno;?>">

                            <span><img src= "resources/star.png"/></span><div id="number_error" class="val_error"></div>
                            <br>

        <label id= "street1">Street</label>
        <input type="text" id="street" name="street" placeholder="Street *" class="tField" value="<?php echo $street;?>">

                            <span><img src= "resources/star.png"/></span><div id="street_error" class="val_error"></div>
                            <br>

        <label id= "barangay1">Barangay</label>
        <input type="text" id="barangay" name="barangay" placeholder="Barangay *" class="tField" value="<?php echo $barangay;?>">

                            <span><img src= "resources/star.png"/></span><div id="barangay_error" class="val_error"></div>
                            <br>

        <label id= "city1">City</label>
        <input type="text" id="city" name="city" placeholder="City *" class="tField" value="<?php echo $city;?>">

                            <span><img src= "resources/star.png"/></span><div id="city_error" class="val_error"></div>
                            <br>
                            <h2 class="reserve-label">- EVENT INFORMATION -</h2>
        <hr width="900"></hr>
        <label id= "date1">Date</label>
        <input type="text" id="txtDate2" name="date1" placeholder="Date of Event *" class="tField" value="<?php echo $date;?>
        ">
                            <span><img src="resources/star.png"/></span><div id="date_error" class="val_error"></div>
                            <br>

        <label id= "time">Time</label>
        <select placeholder="--Select Time--" class= "time1" id= "time1" name="time1" onsubmit="return Validate()" value="<?php echo $time1;?>">

                                <span><img src="resources/star.png"/></span><div id="time1_error" class="val_error"></div>
                                <br>
                                <option value=""></option>
                                <option value="12:00am">12:00 AM</option>
                                <option value="12:30am">12:30 AM</option>
                                <option value="1:00am">1:00 AM</option>
                                <option value="1:30am">1:30 AM</option>
                                <option value="2:00am">2:00 AM</option>
                                <option value="2:30am">2:30 AM</option>
                                <option value="3:00am">3:00 AM</option>
                                <option value="3:30am">3:30 AM</option>
                                <option value="4:00am">4:00 AM</option>
                                <option value="4:30am">4:30 AM</option>
                                <option value="5:00am">5:00 AM</option>
                                <option value="5:30am">5:30 AM</option>
                                <option value="6:00am">6:00 AM</option>
                                <option value="6:30am">6:30 AM</option>
                                <option value="7:00am">7:00 AM</option>
                                <option value="7:30am">7:30 AM</option>
                                <option value="8:00am">8:00 AM</option>
                                <option value="8:30am">8:30 AM</option>
                                <option value="9:00am">9:00 AM</option>
                                <option value="9:30am">9:30 AM</option>
                                <option value="10:00am">10:00 AM</option>
                                <option value="10:30am">10:30 AM</option>
                                <option value="11:00am">11:00 AM</option>
                                <option value="11:30am">11:30 AM</option>
                                
                                <option value="12:00pm">12:00 PM</option>
                                <option value="12:30pm">12:30 PM</option>
                                <option value="1:00pm">1:00 PM</option>
                                <option value="1:30pm">1:30 PM</option>
                                <option value="2:00pm">2:00 PM</option>
                                <option value="2:30pm">2:30 PM</option>
                                <option value="3:00pm">3:00 PM</option>
                                <option value="3:30pm">3:30 PM</option>
                                <option value="4:00pm">4:00 PM</option>
                                <option value="4:30pm">4:30 PM</option>
                                <option value="5:00pm">5:00 PM</option>
                                <option value="5:30pm">5:30 PM</option>
                                <option value="6:00pm">6:00 PM</option>
                                <option value="6:30pm">6:30 PM</option>
                                <option value="7:00pm">7:00 PM</option>
                                <option value="7:30pm">7:30 PM</option>
                                <option value="8:00pm">8:00 PM</option>
                                <option value="8:30pm">8:30 PM</option>
                                <option value="9:00pm">9:00 PM</option>
                                <option value="9:30pm">9:30 PM</option>
                                <option value="10:00pm">10:00 PM</option>
                                <option value="10:30pm">10:30 PM</option>
                                <option value="11:00pm">11:00 PM</option>
                                <option value="11:30pm">11:30 PM</option>
                            </select><span><img src="resources/star.png"/></span>
                            <br><br>

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

        <label id= "theme1">Theme</label>
        <input type= "text" id= "theme" name="theme" placeholder="Event theme *" class="tField" value="<?php echo $theme;?>" onkeyup="javascript:capitalize(this.id, this.value);">
                            
                            <span><img src="resources/star.png"/></span><div id="theme_error" class="val_error"></div>
                            <br>

        <label id= "motif1">Motif</label>
        <input type= "text" id= "motif" name="motif" placeholder="Event motif *" class="tField" value="<?php echo $motif;?>" onkeyup="javascript:capitalize(this.id, this.value);">
                            
                            <span><img src="resources/star.png"/></span><div id="motif_error" class="val_error"></div>
                            <br>

        <h2 class="reserve-label">- PACKAGE INFORMATION -</h2>
        <hr width="900"></hr>

        <label id= "text">Menu Package</label>
        <select class= "menu" id= "menu" name="menu" onchange="updateText(this);" value="<?php echo $menu;?>">
                 <option>--Select menu package--</option>

                    <?php while($row1 = mysqli_fetch_array($result2)):?>
                        <option value="<?php echo $row1[0];?>"><?php echo $row1[0];?></option>
                    <?php endwhile;?>
        </select>

                            <span><img src= "resources/star.png"/></span><div id="menu_error" class="val_error"></div>
                            <br><br>
  

        </div>
        <br><br><br><br><br><br><br><br><br><br><br><br>
        <br><br><br><br><br><br><br><br><br><br><br><br>
        <br><br><br><br><br><br><br><br>

         <div class= "buttons">

    <a href= "terms-and-conditions.php" rel= "stylesheet"/><input type="button" name="submit" value="Back" class="btn"></a>
    <input type="submit" name="insert" id="insert" onclick="myFunction" value="Reserve" class="btn">
    </div>
        </div>
 
    </div><!-- END of CONTENT -->
    <div class="temp-box"></div>
    <!-- Footer PHP FILE -->
        <?php
            include('footer.php');
        ?>

    <!-- import jQuery -->
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"> -->


</body>
</html>
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
    var lastname = document.forms["vForm"]["lastname"];
    var firstname = document.forms["vForm"]["firstname"];
        var contact = document.forms["vForm"]["contact"];
        var birthdate = document.forms["vForm"]["birthdate"];
        var number = document.forms["vForm"]["number"];
        var street = document.forms["vForm"]["street"];
        var barangay = document.forms["vForm"]["barangay"];
        var city = document.forms["vForm"]["city"];
        
        var date = document.forms["vForm"]["date1"];
        var time1 = document.forms["vForm"]["time1"];
        var eventtype = document.forms["vForm"]["eventtype"];
        var pax = document.forms["vForm"]["pax"];
        var venue = document.forms["vForm"]["venue"];
        var theme = document.forms["vForm"]["theme"];
        var motif = document.forms["vForm"]["motif"];
        
        var menu = document.forms["vForm"]["menu"];

    // GETTING ALL ERROR OBJECTS
    var lastname_error = document.getElementById("lastname_error");
    var firstname_error = document.getElementById("firstname_error");
        var contact_error = document.getElementById("contact_error");
        var birthdate_error = document.getElementById("birthdate_error");
        var number_error = document.getElementById("number_error");
        var street_error = document.getElementById("street_error");
        var barangay_error = document.getElementById("barangay_error");
        var city_error = document.getElementById("city_error");
        
        var date_error = document.getElementById("date_error");
        var time1_error = document.getElementById("time1_error");
        var eventtype = document.forms["vForm"]["menu"];
        var pax_error = document.getElementById("pax_error");
        var venue_error = document.getElementById("venue_error");
        var theme_error = document.getElementById("theme_error");
        var motif_error = document.getElementById("motif_error");
    
        var menu = document.forms["vForm"]["menu"];

    // SETTING ALL EVENT LISTENERS
    lastname.addEventListener("blur", lastnameVerify, true);
    firstname.addEventListener( "blur", firstnameVerify, true);
        contact.addEventListener("blur", contactVerify, true);
        birthdate.addEventListener("blur", birthdateVerify, true);
        number.addEventListener("blur", numberVerify, true);
        street.addEventListener("blur", streetVerify, true);
        barangay.addEventListener("blur", barangayVerify, true);
        city.addEventListener("blur", cityVerify, true);
        
        date.addEventListener("blur", dateVerify, true);
        time1.addEventListener("blur", time1Verify, true);
        pax.addEventListener("blur", paxVerify, true);
        venue.addEventListener("blur", venueVerify, true);
        theme.addEventListener("blur", themeVerify, true);
        motif.addEventListener("blur", motifVerify, true);
        eventtype.addEventListener("blur", eventtypeVerify, true);
        
        menu.addEventListener("blur", menuVerify, true);
                
                function Validate(){
        // VALIDATE LASTNAME
        if(lastname.value == ""){
            lastname_error.textContent = "*lastname is required";
            lastname.style.border = "1px solid red";
            lastname.focus();
            return false;
        }
                
                // VALIDATE FIRSTNAME
        if(firstname.value == ""){
            firstname_error.textContent = "*firstname is required";
            firstname.style.border = "1px solid red";
            firstname.focus();
            return false;
        }
                // VALIDATE CONTACT
        if(contact.value == ""){
            contact_error.textContent = "*Contact Number is required";
            contact.style.border = "1px solid red";
            contact.focus();
            return false;
        }    
                
                // VALIDATE BIRTHDATE
        if(birthdate.value == ""){
            birthdate_error.textContent = "*Birthdate is required";
            birthdate.style.border = "1px solid red";
            birthdate.focus();
            return false;
        } 
                
                // VALIDATE LOT NUMBER  
        if(number.value == ""){
            number_error.textContent = "*Lot No./Building No. is required";
            number.style.border = "1px solid red";
            number.focus();
            return false;
        } 
                
                // VALIDATE STREET
        if(street.value == ""){
            street_error.textContent = "*Street is required";
            street.style.border = "1px solid red";
            street.focus();
            return false;
        } 
                
                // VALIDATE BARANGAY   
        if(barangay.value == ""){
            barangay_error.textContent = "*Barangay is required";
            barangay.style.border = "1px solid red";
            barangay.focus();
            return false;
        } 
                
                // VALIDATE CITY
        if(city.value == ""){
            city_error.textContent = "*City is required";
            city.style.border = "1px solid red";
            city.focus();
            return false;
        } 
    
                // VALIDATE DATE
        if(date.value == ""){
            date_error.textContent = "*Date is required";
            date.style.border = "1px solid red";
            date.focus();
            return false;
        }
                
                // VALIDATE TIME
        if(time1.value == ""){
            time_error.textContent = "*Time is required";
            time.style.border = "1px solid red";
            time.focus();
            return false;
        }
                
          // VALIDATE EVENT TYPE
        if(eventtype.value == "--Select Event Type--"){
            eventtype_error.textContent = "*Event Type is required";
            eventtype.style.border = "1px solid red";
            eventtype.focus();
            return false;
        }
                // VALIDATE PAX
        if(pax.value == ""){
            pax_error.textContent = "*Pax is required";
            pax.style.border = "1px solid red";
            pax.focus();
            return false;
        }
                // VALIDATE VENUE
        if(venue.value == ""){
            venue_error.textContent = "*Venue is required";
            venue.style.border = "1px solid red";
            venue.focus();
            return false;
        }
        
          // VALIDATE THEME
        if(theme.value == ""){
            theme_error.textContent = "*Theme is required";
            theme.style.border = "1px solid red";
            theme.focus();
            return false;
        }
          // VALIDATE MOTIF
        if(motif.value == ""){
            motif_error.textContent = "*Motif is required";
            motif.style.border = "1px solid red";
            motif.focus();
            return false;
        }
    }

    // ADD EVENT LISTENERS
    function lastnameVerify(){
        if (lastname.value != "") {
            lastname_error.innerHTML = "";
            lastname.style.border = "1px solid #110E0F";
            return true;
        }
    }
        
        function firstnameVerify(){
        if (firstname.value != "") {
            firstname_error.innerHTML = "";
            firstname.style.border = "1px solid #110E0F";
            return true;
        }
    }
        function contactVerify(){
        if (contact.value != "") {
            contact_error.innerHTML = "";
            contact.style.border = "1px solid #110E0F";
            return true;
        }
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
            
        function birthdateVerify(){
        if (birthdate.value != "") {
            birthdate_error.innerHTML = "";
            birthdate.style.border = "1px solid #110E0F";
            return true;
        }
    }
        
        function numberVerify(){
        if (number.value != "") {
            number_error.innerHTML = "";
            number.style.border = "1px solid #110E0F";
            return true;
        }
    }
        function streetVerify(){
        if (street.value != "") {
            street_error.innerHTML = "";
            street.style.border = "1px solid #110E0F";
            return true;
        }
    }
        function contactVerify(){
        if (contact.value != "") {
            contact_error.innerHTML = "";
            contact.style.border = "1px solid #110E0F";
            return true;
        }
    }
        function barangayVerify(){
        if (barangay.value != "") {
            barangay_error.innerHTML = "";
            barangay.style.border = "1px solid #110E0F";
            return true;
        }
    }
        function cityVerify(){
        if (city.value != "") {
            city_error.innerHTML = "";
            city.style.border = "1px solid #110E0F";
            return true;
        }
    }
        
         function dateVerify(){
        if (date.value != "") {
            date_error.innerHTML = "";
            date.style.border = "1px solid #110E0F";
            return true;
        }
    }
        
         function time1Verify(){
        if(document.getElementsByName("time1")[0].selectedIndex==0){
                    alert("Please select Time from the list");
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
        function themeVerify(){
        if (theme.value != "") {
            theme_error.innerHTML = "";
            theme.style.border = "1px solid #110E0F";
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