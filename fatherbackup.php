<!DOCTYPE html>
<html>
<head>
  <title></title>
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
 <h1 class="big-title">- Reservation -</h1>
    <hr width="900"></hr>
  <ul class="tab">
  <li><a href="javascript:void(0)" class="tablinks" readonly>Customer Info</a></li>
  <li><a href="javascript:void(0)" class="tablinks" readonly>Package</a></li>
  <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'Payment')" id="defaultOpen">Payment</a></li>
</ul>
<div class="order-box">
  <p class="heading"><strong>Customer Information</strong></p>

</div>
<div class="pax-box">

</div>


<div class="payment-box">
<p class="heading-bank"><strong>Choose Payment Option</strong></p>
 <ul class="tabs">
  
  <li>Credit or Debit Card <br><img class="type-img" src="resources/icons/credit.png"><br><input type="radio" class="tablinks2" name="group1" value="CreditDebit" onclick="openBank(event, 'CreditDebit')" id="defaultOpen"> </li>
  <li>BPI <br><img class="type-imgbpi" src="resources/icons/bpi.png"><br><input type="radio" class="tablinks2" name="group1" value="BPI" onclick="openBank(event, 'BPI')"></li>
  
</ul>



<div id="BPI" class="tabcontent2">

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
