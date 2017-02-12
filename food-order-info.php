<?php
session_start();

require_once("dbcontroller.php");
$db_handle = new DBController();

$hostname = "localhost";
$username = "root";
$password = "";
$databaseName = "senordepacencia";
date_default_timezone_set("Asia/Bangkok");
$datereserved = date("Y-m-d");
$account="";
$phpArray = array();
$maxDate="";

if(isset($_SESSION['username']))
{
  $account= $_SESSION['username'];
}


$connect = mysqli_connect($hostname, $username, $password, $databaseName);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try{
    $connect = mysqli_connect($hostname, $username, $password, $databaseName);
    
}catch(Exception $ex)
{
    echo 'Error';
}


$queryDate = "SELECT foodorder_max_date FROM maintenance";

$result1 = mysqli_query($connect, $queryDate);
while ($row1 = mysqli_fetch_array($result1)) {
  $maxDate = $row1["foodorder_max_date"];
}
$queryDates = "SELECT deliverydate, COUNT(*) FROM foodorderinfo GROUP BY deliverydate having count(*) = $maxDate";
$result2 = mysqli_query($connect, $queryDates);
while ($row1 = mysqli_fetch_array($result2)) {
   $phpArray[] = $row1['deliverydate'];
}


if (isset($_POST['submit'])) {
$data = getPost();
$insert_info = "INSERT INTO foodorderinfo VALUES (NULL,'$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]','$data[9]')";
try{

    $insert_info_result = mysqli_query($connect, $insert_info);
    if($insert_info_result)
        {
            if(mysqli_affected_rows($connect) > 0)
            {
        echo "<script>alert('Next step: Payment');document.location='food-order-payment.php'</script>";
            }else{
        echo "<script>alert('Reservation Error!');document.location='index.php'</script>";
            }
        }

    /*foreach ($_SESSION["cart_item"] as $item){
                    $insert_Query = "";
            }*/

}catch(Exception $ex){
    echo $ex;
}
}
function getPost()
{
    date_default_timezone_set("Asia/Bangkok");
if(isset($_SESSION['username']))
  $account = $_SESSION['username'];

    $posts = array();
    $posts[0]= $_POST['firstname'];
    $posts[1]= $_POST['lastname'];
    $posts[2]= $_POST['contact'];
    $posts[3]= $_POST['address'];
    $posts[4]= $_POST['date1'];
    $posts[5]= $_POST['time1'];
    $posts[6]= $datereserved = date("Y-m-d");
    $posts[7]= "unpaid";
    $posts[8]= "pending";
    $posts[9]= $account;
    return $posts;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Senor de Pacencia Enterprise</title>
	<link rel="stylesheet" type="text/css" href="css/payments.css"/>
	<link rel="stylesheet" type="text/css" href="css/product.css"/>

    <script src="jquery/jquery.min.js" type="text/javascript"></script>
    <script src="jquery/jquery-ui.min.js" type="text/javascript"></script>
    <link href="jquery/jquery-ui.css" rel="Stylesheet" type="text/css" />
<script type="text/javascript">
var disableddates = <?php echo json_encode($phpArray); ?>;
function DisableSpecificDates(date) {
    var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
    return [disableddates.indexOf(string) == -1];
  }
	function isNumberKey(evt){
        		var charCode = (evt.which) ? evt.which : event.keyCode
        		if (charCode > 31 && (charCode < 48 || charCode > 57))
        		return false;
        		return true;
   			 }
function capitalize(textboxid, str) {
          // string with alteast one character
         if (str && str.length >= 1){       
             var firstChar = str.charAt(0);
             var remainingStr = str.slice(1);
             str = firstChar.toUpperCase() + remainingStr;
         }
         document.getElementById(textboxid).value = str;
     }
	function myFunction(){
                     /*alert("Success!");*/
                     
               }
	 $(function () {
            $('#txtDate2').datepicker({
                dateFormat: "yy-mm-dd",
                minDate: 7,
                changeMonth: true,
                changeYear: true,
                beforeShowDay: DisableSpecificDates
            });
             
   			  
        });
</script>
</head>
<body>
<?php include('nav-banner.php');
?>
<div class="content-payment">

<h2 class="headingtext">Customer Information</h2>
<!-- customer’s name, contact number, address, date of delivery and time of the delivery -->

<div class="customer-box">

	<form action="" method="POST" onsubmit="return Validate()" name="vForm">
			<p id="note">Note:<img class="star" src= "resources/star.png"/> fields are required.</p>

			<label id="firstname">Firstname</label><input type="text"  class="tField" name="firstname" placeholder="Firstname *" pattern="[a-zA-Z]+" onkeyup="javascript:capitalize(this.id, this.value);"/><span><img class="star" src= "resources/star.png"/></span><div id="firstname_error" class="val_error"></div> 

			<br>
			<label id="lastname">Lastname</label><input type="text" class="tField" name="lastname" placeholder="Lastname *" /><span><img class="star" src= "resources/star.png"/></span><div id="lastname_error" class="val_error"></div> 
			<br>
			<label id="contactno">Contact No </label><input type= "text" name="contact" onblur="checkLength(this)" placeholder="Contact Number *" onkeypress="return isNumberKey(event)" class="tField" maxlength="11"><span><img src= "resources/star.png"/></span><div id="contact_error" class="val_error"></div>
			<br>

			<label id="address">Address</label><input type="text" class="tAddress" name="address" placeholder="Address *" /><span><img class="star" src= "resources/star.png"/></span><div id="address_error" class="val_errorAddress"></div>
			<br>
			<label id= "date1">Date</label><input type="text" id="txtDate2" name="date1" placeholder="Date of Delivery *" class="tField">
                            <span><img src="resources/star.png"/></span><div id="date1_error" class="val_error"></div>
                            <br>
            <label id= "time-1">Time</label>
        <select placeholder="--Select Time--" class= "time1" id= "time1" name="time1" onsubmit="return Validate()">

                                <span><img src="resources/star.png"/></span><div id="time1_error" class="val_error"></div>
                                <br>
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
                            </select><span><img src="resources/star.png"/></span>
                            <br><br>
			<button type="submit" name="submit" class="pay-btn" onclick="myFunction()">PAYMENT</button> 
		</form>
</div>

</div><!--End of Content -->

<!-- Footer PHP FILE -->
<?php include('footer.php');
?>

</body>
</html>

<script type="text/javascript">
	// GETTING ALL INPUT TEXT FIELDS
    	var firstname = document.forms["vForm"]["firstname"];
    	var lastname = document.forms["vForm"]["lastname"];
        var contact = document.forms["vForm"]["contact"];
        var address = document.forms["vForm"]["address"];
        var date1 = document.forms["vForm"]["date1"];
        var time1 = document.forms["vForm"]["time1"];
	// GETTING ALL ERROR OBJECTS
    	var firstname_error = document.getElementById("firstname_error");
    	var lastname_error = document.getElementById("lastname_error");
        var contact_error = document.getElementById("contact_error");
        var address_error = document.getElementById("address_error");
        var date1_error = document.getElementById("date1_error");
        var time1_error = document.getElementById("time1_error");
    // SETTING ALL EVENT LISTENERS
    	firstname.addEventListener( "blur", firstnameVerify, true);
   		lastname.addEventListener("blur", lastnameVerify, true);
        contact.addEventListener("blur", contactVerify, true);
        address.addEventListener("blur", addressVerify, true);
        date1.addEventListener("blur", date1Verify, true);
        time1.addEventListener("blur", time1Verify, true);

        function Validate(){
                
                // VALIDATE FIRSTNAME
        if(firstname.value == ""){
            firstname_error.textContent = "*firstname is required";
            firstname.style.border = "1px solid red";
            firstname.focus();
            return false;
        }
                // VALIDATE LASTNAME
        if(lastname.value == ""){
            lastname_error.textContent = "*lastname is required";
            lastname.style.border = "1px solid red";
            lastname.focus();
            return false;
        }
                // VALIDATE CONTACT
        if(contact.value == ""){
            contact_error.textContent = "*Contact Number is required";
            contact.style.border = "1px solid red";
            contact.focus();
            return false;
        }    
                
                // VALIDATE ADDRESS
        if(address.value == ""){
            address_error.textContent = "*Address is required";
            address.style.border = "1px solid red";
            address.focus();
            return false;
        }
                // VALIDATE DATE
        if(date1.value == ""){
            date1_error.textContent = "*Date is required";
            date1.style.border = "1px solid red";
            date1.focus();
            return false;
        } 
                // VALIDATE TIME
        if(time1.value == ""){
            time1_error.textContent = "*Time is required";
            time1.style.border = "1px solid red";
            time1.focus();
            return false;
        }  
    }

    // ADD EVENT LISTENERS
        
        function firstnameVerify(){
        if (firstname.value != "") {
            firstname_error.innerHTML = "";
            firstname.style.border = "1px solid #110E0F";
            return true;
        }
    }
        function lastnameVerify(){
        if (lastname.value != "") {
            lastname_error.innerHTML = "";
            lastname.style.border = "1px solid #110E0F";
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
            
        function addressVerify(){
        if (address.value != "") {
            address_error.innerHTML = "";
            address.style.border = "1px solid #110E0F";
            return true;
        }
    }
  	  	function date1Verify(){
  	    if (date1.value != "") {
  	        date1_error.innerHTML = "";
  	        date1.style.border = "1px solid #110E0F";
  	        return true;
  	     }
   	 }
    	function time1Verify(){
        if (time1.value != "") {
            time1_error.innerHTML = "";
            time1.style.border = "1px solid #110E0F";
            return true;
        }
    }
	

</script>