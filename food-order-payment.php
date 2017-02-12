<?php
  session_start();
$hostname = "localhost";
$username = "root";
$password = "";
$databaseName = "senordepacencia";
// define variables and set to empty values

$qfname="";
$qlname="";
$qcontact ="";
$deliveryDate="";
$deliveryTime ="";
$qvenue = "";


  date_default_timezone_set("Asia/Bangkok");
  $datereserved = date("Y-m-d");

$total="";
$account ="none";

$qFiftyPercent="";


if(isset($_SESSION['username']))
{
  $account= $_SESSION['username'];

  $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');


  $select_customer=mysql_query("SELECT * FROM foodorderinfo WHERE username='$account' AND paymentstatus='unpaid' AND foi_id =(SELECT MAX(foi_id) FROM foodorderinfo)");
  while($row=mysql_fetch_array($select_customer))
  {
    $_SESSION['foi_id'] = $row['foi_id'];
    $qfname = $row['firstname'];
    $qlname = $row['lastname'];
    $qcontact = $row['contactno'];
    $qvenue = $row['address'];
    $deliveryDate = $row['deliverydate'];
    $deliveryTime = $row['deliverytime'];

  }
}


  

$connect = mysqli_connect($hostname, $username, $password, $databaseName);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try{
    $connect = mysqli_connect($hostname, $username, $password, $databaseName);
    
}catch(Exception $ex)
{
    echo 'Error';
}




if (isset($_POST['submit'])) {
$data = getPosts();
    $insert_Query = "INSERT INTO `creditdebit` (`cb_id`, `cardnumber`, `nameoncard`, `expmonth`, `expyear`, `ccv`, `totalamount`, `datepaid`, `pkgrsv_id`, `username`) VALUES (NULL, '$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$qTotal', '$data[6]', '$rsv_max_id', '$data[7]');";
    
   try
    {
        $insert_Result = mysqli_query($connect, $insert_Query);
        if($insert_Result)
        {
            if(mysqli_affected_rows($connect) > 0)
            {
              
              echo "<script>alert('Reservation Successful!');document.location='sampleprint.php'</script>";
               
            }
        
            else
            {
                 echo "<script>alert('Reservation Failed!');document.location='reservationPayment.php'</script>";
            }
        }
        
        
    }catch(Exception $ex)
    {
        echo 'Error Insert'.$ex->getMessage();
    }

    try{
      $update_status = "UPDATE `packagereserve` SET `paymentstatus` = 'paid' WHERE `packagereserve`.`pkgrsv_id` = '$rsv_max_id';";
            $update_status = mysqli_query($connect, $update_status);
            if(mysqli_affected_rows($connect) > 0)
                {
                  //Do something
                }
    }catch(Exception $ex){
      echo "Error Update Status";
    }
}

if(isset($_POST["bpi_submit"])) {
if($_FILES['fileToUpload']['name']!='')
{
  if($_POST['amountpaid']<$qFiftyPercent)
  {
echo "<script>alert('Invalid Amount!');document.location='reservationPayment.php'</script>";
  }else
  {
    date_default_timezone_set("Asia/Bangkok");
    $imagename=$_FILES["fileToUpload"]["name"]; 
    $session_foi_id = $_SESSION['foi_id'];
    $total_amount = $_SESSION['total'];
    //Get the content of the image and then add slashes to it 
    $imagetmp=addslashes (file_get_contents($_FILES['fileToUpload']['tmp_name']));
    $amount = $_POST['amountpaid'];
    $date = date("Y-m-d");
    $status = "pending";
    $type="foodorder";
    $query = "INSERT INTO bpipayment VALUES(NULL, '$amount','$imagetmp','$imagename','$date', '$status', '$type', '$account')";
    $query_update = "UPDATE `foodorderinfo` SET `paymentstatus` = 'paid' WHERE `foodorderinfo`.`foi_id` = $session_foi_id";
    $query_foodorder = "INSERT INTO foodorderdetails VALUES (NULL, '$session_foi_id', '$total_amount', '$account')";
     try
    {
        $insert_Result = mysqli_query($connect, $query);
        if($insert_Result)
        {
            if(mysqli_affected_rows($connect) > 0)
            {
                $update_Result = mysqli_query($connect, $query_update);
                if($update_Result)
                {
                  if(mysqli_affected_rows($connect) > 0)
                        {
                            $insert_details= mysqli_query($connect, $query_foodorder);
                            if ($insert_details) {
                              if(mysqli_affected_rows($connect) > 0)
                              {
                                  foreach ($_SESSION["cart_item"] as $data){
                                  $data1=$data['m_name'];
                                  $data2=$data['code'];
                                  $data3=$data['quantity'];
                                  $data4=$data['m_price'];
                                  $insert_menus = "INSERT INTO `foodordermenus` (`fom_id`, `foi_id`, `m_name`, `code`, `quantity`, `m_price`) VALUES (NULL, '$session_foi_id', '$data1', '$data2', '$data3', '$data4');";

                            $query_insert = mysqli_query($connect, $insert_menus);

                            if($query_insert){
                                if(mysqli_affected_rows($connect) > 0)
                                {

                                }
                            }

                          }
                          echo "<script>alert('Food Order Success! ');document.location='dashboard.php'</script>";
                        }
                              }
                            }
                        }
                }//END of IF mysqli_affected_rows for $update_Result 
      
            }//END of IF mysqli_affected_rows for $insert_Result
            else
            {
                 echo "<script>alert('Reservation Failed!');document.location='food-order-payment.php'</script>";
            }
       
        
    }catch(Exception $ex)
    {
        echo 'Error Insert'.$ex->getMessage();
    }
  }
  
}else{
  echo "<script>alert('No File Selected!');document.location='food-order-payment.php'</script>";
}

}

function getPosts()
{

date_default_timezone_set("Asia/Bangkok");
if(isset($_SESSION['username']))
  $account = $_SESSION['username'];
    $posts = array();
    $posts[0]= $_POST['cardnumber'];
    $posts[1]= $_POST['cardname'];
    $posts[2]= $_POST['cmonth'];
    $posts[3]= $_POST['cyear'];
    $posts[4]= $_POST['ccv'];
   /* $posts[5]= $qTotal; NO NEED*/
/*    $posts[5]= $rsv_max_id;*/
    $posts[6]= $datereserved = date("Y-m-d");
    $posts[7]= $account;
    return $posts;
}

?>

<!DOCTYPE HTML>  
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/reservation-style.css">
<link rel="stylesheet" type="text/css" href="css/header-center.css">

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

function myFunction() {
    var x = $numberofpax;
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
    function checkLength(el){
                 
                 if(el.value.length != 16){
                    alert("Length must be exactly 16 numbers");
                    cardnumber_error.textContent = "*Card Number is required";
                    return false;
                }
            }
    function checkAmount(el){
        var temp = <?php echo $qFiftyPercent;?>

                 if(el.value < temp){
                    alert("Invalid Amount Paid");
                    amountpaid_error.textContent = "*Invalid Amount Paid";
                    amountpaid.focus();
                    return false;
                }else{
                  amountpaid_error.textContent = "";
                    return true;
                }
            }
    function checkName(en){
      if(en.value=="")
      {
            cardname_error.textContent = "*Card name is required";
            return false;
      }
    }
</script>


</head>
<body>  
<?php include('nav-banner.php');
?>
<div class="content-payment">
 <h1 class="big-title">- Food Order -</h1>
    <hr width="900"></hr>
  <ul class="tab">
  <li><a href="javascript:void(0)" class="tablinks" readonly>Menus</a></li>
  <li><a href="javascript:void(0)" class="tablinks" readonly>Food Order Information</a></li>
  <li><a href="javascript:void(0)" class="tablinks" readonly>Payment</a></li>
</ul>
<div class="order-box">
  <p class="heading"><strong>Customer Information<span class="return_">[ <a style="text-decoration: none; color: red;" href="food-order-info-edit.php">Edit Customer Information</a> ]</span></strong></p>
  <?php
   echo "<table class='tbl-head' cellpadding='10' cellspacing='1'>";
   echo "<tbody>";
   echo "<tr><td><strong> Name:</strong></td><td>".$qfname." ". $qlname."</td></tr>";
   echo "<tr><td><strong>Mobile Number: </strong></td><td>".$qcontact."</td></tr>";
   echo "<tr><td><strong>Delivery Date: </strong></td><td>". $deliveryDate."</td></tr>";
   echo "<tr><td><strong>Delivery Time: </strong></td><td>".$deliveryTime."</td></tr>";
   echo "<tr><td><strong>Address: </strong></td><td>".$qvenue."<br>";
   echo "</tbody>";
   echo "</table>";
 ?>
</div>
<div class="pax-box">

  <p class="heading"><strong>Menu Information<span class="return_">[ <a style="text-decoration: none; color: red;" href="food-order.php">Return to Food Order</a> ]</span></strong></p>
  <?php 
  if(isset($_SESSION["cart_item"])){
    $item_total = 0; 
     ?>
  
<table cellpadding="10" cellspacing="1">
<tbody>
<tr>
<th><strong>Name</strong></th>
<th><strong>Code</strong></th>
<th><strong>Quantity</strong></th>
<th><strong>Price</strong></th>
</tr> 
     <?php
  foreach ($_SESSION["cart_item"] as $item){
   echo "<tr><td>".$item['m_name']."</td><td>".$item['code']."</td><td>". $item['quantity']."</td><td>".$item['m_price']."</td></tr>";
   $item_total += ($item["m_price"]*$item["quantity"]);

  }
  $_SESSION['total'] =$item_total;
  $qFiftyPercent=$_SESSION['total']/2;
  echo "<tr><td colspan='5' align=right><strong>Total:</strong> P".$item_total."</td></tr>";
  echo "</tbody>";
  echo "</table>";
    }?>
</div>


<div class="payment-box">
<p class="heading-bank"><strong>Choose Payment Option</strong></p>
 <ul class="tabs">
  
  <li>Credit or Debit Card <br><img class="type-img" src="resources/icons/credit.png"><br><input type="radio" class="tablinks2" name="group1" value="CreditDebit" onclick="openBank(event, 'CreditDebit')" id="defaultOpen"> </li>
  <li>BPI <br><img class="type-imgbpi" src="resources/icons/bpi.png"><br><input type="radio" class="tablinks2" name="group1" value="BPI" onclick="openBank(event, 'BPI')"></li>
  
</ul>

<div id="CreditDebit" class="tabcontent2">
  <div class="note_payment">
    <p>NOTE: PAYMENT SHOULD BE AT LEAST 50% OF TOTAL AMOUNT. &nbsp;&nbsp;<strong>( P <?php echo $qFiftyPercent;?> )</strong></p>
  </div>
<form method="POST" name="vForm" onsubmit="return Validate()"> 
<label>Card Number</label><br><br><br>
<input type="text" class="txtField" maxlength="16" name="cardnumber" onkeypress="return isNumberKey(event)" onblur="checkLength(this)"><div id="cardnumber_error" class="val_error_p"></div>
                            <br><br>
<label>Name on Card</label><br><br><br>
<input type="text" class="txtField" name="cardname" onkeypress="return checkName(event)"><div id="cardname_error" class="val_error_p"></div><br>
<label>Expiry Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
<label>CCV/CVV</label><div class="hover_img">
     <br><a href="#"><strong>?</strong><span><img src="resources/icons/ccv.png" alt="image" height="150" /></span></a>
</div><br><br><br>

<input type="text" maxlength="2" name="cmonth" class="tfexpiry" placeholder="mm" onkeypress="return isNumberKey(event)"><div id="cmonth_error" class="val_error_exp"></div> 


<input type="text" maxlength="2" name="cyear" class="tfexpiry" placeholder="yy" onkeypress="return isNumberKey(event)"><div id="cyear_error" class="val_error_exp"></div>

 <input type="text" maxlength="4" name="ccv" class="tfccv" placeholder="ccv" onkeypress="return isNumberKey(event)"><div id="ccv_error" class="val_error_p"></div>
<br>
<input type="submit" class="btn-payment" name="submit" value="RESERVE">
</form>
</div>

<div id="BPI" class="tabcontent2">
  <div class="note_payment">
    <p>NOTE: PAYMENT SHOULD BE AT LEAST 50% OF TOTAL AMOUNT. &nbsp;&nbsp;<strong>( P <?php echo $qFiftyPercent;?> )</strong></p>
  </div>
<?php
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');

  $select=mysql_query("SELECT * FROM bpiaccount");
  while($row=mysql_fetch_array($select))
  {
    $qaccountno = $row['accountno'];
    $qmerchantname = $row['merchantname'];
  }
  ?>
<form method="POST" action="" enctype="multipart/form-data" onsubmit="return Validate2()" name="vForm2">
<p class="accountnum"><strong>ACCOUNT NUMBER: </strong><?php echo $qaccountno;?></p>
<p class="accountnum"><strong>MERCHANT'S NAME: </strong><?php echo $qmerchantname;?></p>
<p class="accountnum"><strong>AMOUNT IN PHP: </strong><input type="text" class="txtField" name="amountpaid" onblur="checkAmount(this)"></p><div id="amountpaid_error" class="val_error_bpi"></div> 

<br>
<p class="accountnum"><strong>UPLOAD DEPOSIT / PAYMENT SLIP: </strong></p><div class="hover_bpi"><a href="#"><strong>?</strong><span><img src="resources/icons/deposit.gif" alt="image" height="300" /></span></a><br>
 <input type="file" id="imgInp" name="fileToUpload" id="fileToUpload"><div id="fileToUpload_error" class="val_error_bpi"></div><br>
 <img id="up_preview" src="resources/icons/image.png" alt="your image" /><br>


 <input type="submit" class="btn-payment" name="bpi_submit" value="RESERVE">
</form>
</div>   
</div>

</div><!--End of Content -->

</body>
</html>
<script>
function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#up_preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgInp").change(function(){
    readURL(this);
});

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
<script type="text/javascript">
function openBank(evt, bankName) {
    var i, tabcontent2, tablinks2;
    tabcontent2 = document.getElementsByClassName("tabcontent2");
    for (i = 0; i < tabcontent2.length; i++) {
        tabcontent2[i].style.display = "none";
    }
    tablinks2 = document.getElementsByClassName("tablinks2");
    for (i = 0; i < tablinks2.length; i++) {
        tablinks2[i].className = tablinks2[i].className.replace(" active", "");
    }
    document.getElementById(bankName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();


var cardnumber = document.forms['vForm']['cardnumber'];
var cardname = document.forms['vForm']['cardname'];
var cmonth = document.forms['vForm']['cmonth'];
var cyear = document.forms['vForm']['cyear'];
var ccv = document.forms['vForm']['ccv'];

var fileToUpload_error = document.getElementById("fileToUpload_error");
var amountpaid_error = document.getElementById("amountpaid_error");
var cardnumber_error = document.getElementById("cardnumber_error");
var cardname_error = document.getElementById("cardname_error");
var cmonth_error = document.getElementById("cmonth_error");
var cyear_error = document.getElementById("cyear_error");
var ccv_error = document.getElementById("ccv_error");

fileToUpload.addEventListener("blur", fileToUploadVerify, true);
amountpaid.addEventListener("blur", amountpaidVerify, true);
cardnumber.addEventListener("blur", cardnumberVerify, true);
cardnumber.addEventListener("blur", cardnumberVerify2, true);
cardname.addEventListener("blur", cardnameVerify, true);
cmonth.addEventListener("blur", cmonthVerify, true);
cyear.addEventListener("blur", cyearVerify, true);
ccv.addEventListener("blur", ccvVerify, true);

function Validate2()
{
  if(amountpaid.value == ""){
            amountpaid_error.textContent = "*Amount Paid is required";
            amountpaid.style.border = "1px solid red";
            amountpaid.focus();
            return false;
        }
    if(amountpaid.value < $qFiftyPercent){
            amountpaid_error.textContent = "*Invalid Amount Paid";
            amountpaid.style.border = "1px solid red";
            amountpaid.focus();
            return false;
        }
    if(fileToUpload.value == ""){
            fileToUpload_error.textContent = "*Invalid Amount Paid";
            fileToUpload.style.border = "1px solid red";
            fileToUpload.focus();
            return false;
        }
  
}
  function amountpaidVerify(){
        if (cardnumber.value != "") {
            cardnumber_error.innerHTML = "";
            cardnumber.style.border = "1px solid #110E0F";
            return true;
        }
    }
function Validate()
{
  
  if(cardnumber.value == ""){
            cardnumber_error.textContent = "*Card Number is required";
            cardnumber.style.border = "1px solid red";
            cardnumber.focus();
            return false;
        }
  if(cardname.value == ""){
            cardname_error.textContent = "*Name on Card is required";
            cardname.style.border = "1px solid red";
            cardname.focus();
            return false;
        }
    if(cmonth.value == ""){
            cmonth_error.textContent = "*Please enter expiry date";
            cmonth.style.border = "1px solid red";
            cmonth.focus();
            return false;
        }
    if(cyear.value == ""){
            cyear_error.textContent = "*Please enter expiry date";
            cyear.style.border = "1px solid red";
            cyear.focus();
            return false;
        }
    if(ccv.value == ""){
            ccv_error.textContent = "*Please enter ccv/cvv";
            ccv.style.border = "1px solid red";
            ccv.focus();
            return false;
        }
}

function cardnumberVerify(){
        if (cardnumber.value != "") {
            cardnumber_error.innerHTML = "";
            cardnumber.style.border = "1px solid #110E0F";
            return true;
        }
    }
function cardnumberVerify2(){
  if(cardnumber.value.length != 16)
          {
            cardnumber_error.innerHTML = "*Card Number must be 16 digits";
            return true;
          }
}
function cardnameVerify(){
        if (cardname.value != "") {
            cardname_error.innerHTML = "";
            cardname.style.border = "1px solid #110E0F";
            return true;
        }
    }
function cmonthVerify(){
        if (cmonth.value != "") {
            cmonth_error.innerHTML = "";
            cmonth.style.border = "1px solid #110E0F";
            return true;
        }
    } 
function cyearVerify(){
        if (cyear.value != "") {
            cyear_error.innerHTML = "";
            cyear.style.border = "1px solid #110E0F";
            return true;
        }
    }
function ccvVerify(){
        if (ccv.value != "") {
            ccv_error.innerHTML = "";
            ccv.style.border = "1px solid #110E0F";
            return true;
        }
    } 
</script>
