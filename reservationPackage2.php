<?php
  session_start();
$hostname = "localhost";
$username = "root";
$password = "";
$databaseName = "senordepacencia";
// define variables and set to empty values
$packagename="";
$opt[1]="";
$opt[2]="";
$opt[3]="";
$opt[4]="";
  date_default_timezone_set("Asia/Bangkok");
  $datereserved = date("Y-m-d");
$packageprice=0;
$optional="";
$please="";
$optional1="";
$optional2="";
$optional3="";
$optional4="";
$counter="";
$count="";
$numberofpax=0;
$total="";
$account ="none";
$paxAprice="";
$paxBprice="";
if(isset($_SESSION['username']))
{
  $account= $_SESSION['username'];

  $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');

  $select=mysql_query("SELECT pax from reservationlist WHERE username='$account' && status='pending' && rsv_id=(SELECT MAX(rsv_id) FROM reservationlist)");
  while($row=mysql_fetch_array($select))
  {
   $num = $row['pax'];
   $numberofpax = Intval($num);
  }
  $select1=mysql_query("SELECT price_per_head from package WHERE pkg_name= 'SetA'");
  while($row=mysql_fetch_array($select1))
  {
   $paxAprice = $row['price_per_head'];
  }
  $select2=mysql_query("SELECT price_per_head from package WHERE pkg_name= 'SetB'");
  while($row=mysql_fetch_array($select2))
  {
   $paxBprice = $row['price_per_head'];
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

$query = "SELECT * FROM eventtype";

$result1 = mysqli_query($connect, $query);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

$datas = getMenus();
$stat = "pending";
$paymentStat = "unpaid";
$insert_Menus = "INSERT INTO menureserved VALUES ('$datas[0]','$datas[1]','$datas[2]','$datas[3]','$datas[4]','$datas[5]','$datas[6]','$datas[7]','$datas[8]', '$datereserved','$paymentStat', '$stat', '$datas[9]')";
 try
    {
        $insert_ResultMenus = mysqli_query($connect, $insert_Menus);
        if($insert_ResultMenus)
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

$data = getPosts();
$paymentstatus = "unpaid";
$status = "pending";


    $insert_Query = "INSERT INTO `packagereserve` (`pkg_name`, `op1`, `op2`, `op3`, `op4`, `total`, `datereserved`, `paymentstatus`, `status`, `username`) VALUES ('$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$data[5]', '$data[6]', '$paymentstatus', '$status', '$data[7]');";
    
   try
    {
        $insert_Result = mysqli_query($connect, $insert_Query);
        if($insert_Result)
        {
            if(mysqli_affected_rows($connect) > 0)
            {
              
              echo "<script>alert('Last Step: Payment');document.location='reservationPayment.php'</script>";
               
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
function getPosts()
{
$O1="";
$O2="";
$O3="";
$O4="";
$tempTotal="";
date_default_timezone_set("Asia/Bangkok");
if(isset($_SESSION['username']))
  $account = $_SESSION['username'];

if(!isset($_POST['selectedItems1']))
{
  $O1= "none"; 
}else{
  $O1=$_POST['selectedItems1'];
}
if(!isset($_POST['selectedItems2']))
{
  $O2= "none"; 
}else{
  $O2=$_POST['selectedItems2'];
}
if(!isset($_POST['selectedItems3']))
{
  $O3= "none"; 
}else{
  $O3=$_POST['selectedItems3'];
}
if(!isset($_POST['selectedItems4']))
{
  $O4= "none"; 
}else{
  $O4=$_POST['selectedItems4'];
}
if(!isset($_POST['txtbox_total']))
{
  $tempTotal = $_POST['txtbox-total'];
}else{
  echo "<script>alert('Reservation Failed!');</script>";
}
    $posts = array();
    $posts[0]= $_POST['packageSet'];
    $posts[1]= $O1;
    $posts[2]= $O2;
    $posts[3]= $O3;
    $posts[4]= $O4;
   
    $posts[5]= $_POST['txtbox-total'];  

    

    $posts[6]=  $datereserved = date("Y-m-d");
    $posts[7]= $account;
    return $posts;
}

function getMenus()
{
  if(isset($_SESSION['username']))
  $account = $_SESSION['username'];


  $temp = $_POST['packageSet'];
  $menus = array();
  if($temp == 'SetA')
  {
    $veg = "none";
    
  $menus[0] = $temp;
  $menus[1] = $_POST['beef'];
  $menus[2] = $_POST['fish'];
  $menus[3] = $_POST['chicken'];
  $menus[4] = $_POST['noodles'];
  $menus[5] = $veg;
  $menus[6] = $_POST['rice'];
  $menus[7] = $_POST['dessert'];
  $menus[8] = $_POST['drinks'];
  $menus[9] = $account;
  return $menus;
  }
  if ($temp == 'SetB') {
  $menus[0] = $temp;
  $menus[1] = $_POST['beef2'];
  $menus[2] = $_POST['fish2'];
  $menus[3] = $_POST['chicken2'];
  $menus[4] = $_POST['noodles2'];
  $menus[5] = $_POST['vegetables2'];
  $menus[6] = $_POST['rice2'];
  $menus[7] = $_POST['dessert2'];
  $menus[8] = $_POST['drinks2'];
  $menus[9] = $account;
  return $menus;
  }
  
  
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


function myFunction() {
    var x = $numberofpax;
    var value = parseInt(x);
    $numberofpax = value;

    document.getElementById("paxno-txt").innerHTML = $numberofpax;
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
  <li><a href="javascript:void(0)" class="tablinks" readonly>Customer Info</a></li>
  <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'Package')" id="defaultOpen" >Package</a></li>
  <li><a href="javascript:void(0)" class="tablinks" readonly>Payment</a></li>
</ul>


<div id="Package" class="tabcontent">
  <!-- <span onclick="this.parentElement.style.display='none'" class="topright">x</span> -->



<form method="POST" action="">
  <div class="price-box">
  <p class="total-pax"><strong>No of Guests: </strong></p><p class="pax-txt" id="paxno-txt"><?php echo $numberofpax;?></p>
  <p class="total-pax-price"><strong>Price per Guests: </strong></p> <p class="pax-price" id="pax-txt"></p>
  <p class="total-adds"><strong>Sub Total: </strong></p> <p class="pax-price" id="sub-txt"></p>
  <p class="total-adds"><strong>Additional: </strong></p>
   <p id="optional-txt1"></p>
   <p id="optional-txt2"></p>
   <p id="optional-txt3"></p>
   <p id="optional-txt4"></p>
  <p class="total-"><strong>Total: (PHP)</strong></p> <p class="total-p" id="total-txt"></p>
  <input type="text" class="boxtotal" id="txtbox-total" name="txtbox-total" readonly/>

</div>

<div class="MENUPACKAGE">

<label id= "text" class="menupax" style="background-color: rgb(255, 154, 53);">MENU PACKAGE :</label>

<ul class="tabs1">
  
  <li style="background-color: rgb(255, 154, 53); padding: 5.5px;">Set A<input type="radio" class="tablinks2" name="packageSet" value="SetA" onclick="openBank(event, 'SetA')" id="defaultOpen"> </li>
  <li style="background-color: rgb(255, 154, 53); padding: 5.5px; padding-right: 254.9px;">Set B<input type="radio" class="tablinks2" name="packageSet" value="SetB" onclick="openBank(event, 'SetB')"></li>
  
</ul>



      <div id="SetA" class="tabcontentPax">
          <table class="tbl-head" cellpadding="10" cellspacing="1">
      <tbody>
      <tr>
      <th style="background-color: rgb(255, 154, 53);"><strong>TYPE</strong></th>
      <th style="background-color: rgb(255, 154, 53);"><strong>NAME</strong></th>
      
      </tr>
      <tr>
        <td>BEEF:</td>
        <td><select name="beef">
        <?php
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');
  $query=mysql_query("SELECT pcl_name from packagelist WHERE pcl_details = 'beef'");
  while($row=mysql_fetch_array($query))
  {     
   echo "<option>".$row['pcl_name']."</option>";
  }
 ?>
        </select></td>
      </tr>
      <tr>
        <td>FISH:</td>
        <td><select name="fish">
        <?php
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');
  $query=mysql_query("SELECT pcl_name from packagelist WHERE pcl_details = 'fish'");
  while($row=mysql_fetch_array($query))
  {     
   echo "<option>".$row['pcl_name']."</option>";
  }
 ?>
        </select></td>
      </tr>
      <tr>
        <td>CHICKEN:</td>
        <td><select name="chicken">
        <?php
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');
  $query=mysql_query("SELECT pcl_name from packagelist WHERE pcl_details = 'chicken'");
  while($row=mysql_fetch_array($query))
  {     
   echo "<option>".$row['pcl_name']."</option>";
  }
 ?>
        </select></td>
      </tr>
      <tr>
        <td>NOODLES:</td>
        <td><select name="noodles">
        <?php
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');
  $query=mysql_query("SELECT pcl_name from packagelist WHERE pcl_details = 'noodles'");
  while($row=mysql_fetch_array($query))
  {     
   echo "<option>".$row['pcl_name']."</option>";
  }
 ?>
        </select></td>
      </tr>
      <tr>
        <td>RICE:</td>
        <td><select name="rice">
        <?php
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');
  $query=mysql_query("SELECT pcl_name from packagelist WHERE pcl_details = 'rice'");
  while($row=mysql_fetch_array($query))
  {     
   echo "<option>".$row['pcl_name']."</option>";
  }
 ?>
        </select></td>
      </tr>
      <tr>
        <td>DESSERT:</td>
        <td><select name="dessert">
        <?php
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');
  $query=mysql_query("SELECT pcl_name from packagelist WHERE pcl_details = 'dessert'");
  while($row=mysql_fetch_array($query))
  {     
   echo "<option>".$row['pcl_name']."</option>";
  }
 ?>
        </select></td>
      </tr>
      <tr>
        <td>DRINKS:</td>
        <td><select name="drinks">
        <?php
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');
  $query=mysql_query("SELECT pcl_name from packagelist WHERE pcl_details = 'drinks'");
  while($row=mysql_fetch_array($query))
  {     
   echo "<option>".$row['pcl_name']."</option>";
  }
 ?>
        </select></td>
      </tr>
      </tbody>
      </table> 
      </div>

      <div id="SetB" class="tabcontentPax">
          <table class="tbl-head" cellpadding="10" cellspacing="1">
      <tbody>
      <tr>
      <th style="background-color: rgb(255, 154, 53);"><strong>TYPE</strong></th>
      <th style="background-color: rgb(255, 154, 53);"><strong>NAME</strong></th>
      
      </tr>
      <tr>
        <td>BEEF:</td>
        <td><select name="beef2">
        <?php
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');
  $query=mysql_query("SELECT pcl_name from packagelist WHERE pcl_details = 'beef'");
  while($row=mysql_fetch_array($query))
  {     
   echo "<option>".$row['pcl_name']."</option>";
  }
 ?>
        </select></td>
      </tr>
      <tr>
        <td>FISH:</td>
        <td><select name="fish2">
        <?php
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');
  $query=mysql_query("SELECT pcl_name from packagelist WHERE pcl_details = 'fish'");
  while($row=mysql_fetch_array($query))
  {     
   echo "<option>".$row['pcl_name']."</option>";
  }
 ?>
        </select></td>
      </tr>
      <tr>
        <td>CHICKEN:</td>
        <td><select name="chicken2">
        <?php
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');
  $query=mysql_query("SELECT pcl_name from packagelist WHERE pcl_details = 'chicken'");
  while($row=mysql_fetch_array($query))
  {     
   echo "<option>".$row['pcl_name']."</option>";
  }
 ?>
        </select></td>
      </tr>
      <tr>
        <td>NOODLES:</td>
        <td><select name="noodles2">
        <?php
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');
  $query=mysql_query("SELECT pcl_name from packagelist WHERE pcl_details = 'noodles'");
  while($row=mysql_fetch_array($query))
  {     
   echo "<option>".$row['pcl_name']."</option>";
  }
 ?>
        </select></td>
      </tr>
      <td>VEGETABLES:</td>
        <td><select name="vegetables2">
        <?php
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');
  $query=mysql_query("SELECT pcl_name from packagelist WHERE pcl_details = 'vegetables'");
  while($row=mysql_fetch_array($query))
  {     
   echo "<option>".$row['pcl_name']."</option>";
  }
 ?>
        </select></td>
      </tr>
      <tr>
        <td>RICE:</td>
        <td><select name="rice2">
        <?php
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');
  $query=mysql_query("SELECT pcl_name from packagelist WHERE pcl_details = 'rice'");
  while($row=mysql_fetch_array($query))
  {     
   echo "<option>".$row['pcl_name']."</option>";
  }
 ?>
        </select></td>
      </tr>
      <tr>
        <td>DESSERT:</td>
        <td><select name="dessert2">
        <?php
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');
  $query=mysql_query("SELECT pcl_name from packagelist WHERE pcl_details = 'dessert'");
  while($row=mysql_fetch_array($query))
  {     
   echo "<option>".$row['pcl_name']."</option>";
  }
 ?>
        </select></td>
      </tr>
      <tr>
        <td>DRINKS:</td>
        <td><select name="drinks2">
        <?php
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');
  $query=mysql_query("SELECT pcl_name from packagelist WHERE pcl_details = 'drinks'");
  while($row=mysql_fetch_array($query))
  {     
   echo "<option>".$row['pcl_name']."</option>";
  }
 ?>
        </select></td>
      </tr>
      </tbody>
      </table> 
      </div>

  
</div>
<script>
function displayVals() {
 
  var singleValues =  $("input[name='packageSet']:checked").val();
  if(singleValues == "SetA")
  {    
   var pax = "<?php echo $numberofpax?>";
        singleValues = "<?php echo $paxAprice;?>";
        $packageprice=singleValues;
        $total = $packageprice * pax;
        $counter = $total;
        $count = $counter;
        $( "#pax-txt" ).html( 'P '+ $packageprice );
         $( "#sub-txt" ).html( pax + ' x P'+ $packageprice + ' = P' + $total );
        $("#txtbox-total").val( $total);
    var temp = $optional;
        if(temp != 0)
          $total = $total + temp;
        
        $( "#total-txt" ).html( $total );
  }
  if(singleValues == "SetB")
  {
        
        var pax = "<?php echo $numberofpax?>";
        singleValues = "<?php echo $paxBprice;?>";
        $packageprice=singleValues;
        $total = $packageprice * pax;
        $counter = $total;
        $count = $counter;
        $( "#pax-txt" ).html( 'P '+ $packageprice );
         $( "#sub-txt" ).html( pax + ' x P'+ $packageprice + ' = P' + $total );
        $("#txtbox-total").val( $total);
    var temp = $optional;
        if(temp != 0)
          $total = $total + temp;
        
        $("#txtbox-total").val($total);
     
  }
  else{
    var pax = "<?php echo $numberofpax?>";
        singleValues = 0;
        $packageprice=singleValues;
        $total = $packageprice * pax;
        $counter = $total;
        $count = $counter;
        $( "#pax-txt" ).html( $packageprice );
        $("#txtbox-total").val($total);
    var temp = $optional;
        if(temp != 0)
          $total = $total + temp;
        
        $("#txtbox-total").val($total);
  }

}

$( ".tablinks2" ).change( displayVals );
displayVals();

</script>



<label id= "text2">OPTIONAL :</label>


<div class="box-pax-optional">

      <table class="tbl-head" cellpadding="10" cellspacing="1">
      <tbody>
      <tr>
      <th style="background-color: rgb(255, 154, 53);"><strong>Option</strong></th>
      <th style="background-color: rgb(255, 154, 53);"><strong>Name</strong></th>
      <th style="background-color: rgb(255, 154, 53);"><strong>Details</strong></th>
      <th style="background-color: rgb(255, 154, 53);"><strong>Price</strong></th>
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
   $opt[$option] = $row['op_price'];
    $option++;
  }
 ?>

      </tbody>
      </table>
<label>Option 1<input type="checkbox" class="chkBox" name="selectedItems1" value="Salad Bar A" /></label>
<label>Option 2<input type="checkbox" class="chkBox" name="selectedItems2" value="Salad Bar B" /></label>
<label>Option 3<input type="checkbox" class="chkBox" name="selectedItems3" value="Chocolate Fountain A" /></label>
<label>Option 4<input type="checkbox" class="chkBox" name="selectedItems4" value="Chocolate Fountain B" /></label>

</div>
  <input type="submit" class="btn" name="submit" value="Proceed to Payment">
  </form>
<script type="text/javascript">
 var packs = <?php echo json_encode($numberofpax); ?>

  $('input[name="selectedItems1"]').click(function(){ 
  if (this.checked) {
if($total > $counter)
      {
        $total = $counter;
      }
   
    var temp = packs;
    var d1 = <?php echo $opt[1];?> * temp;
    $optional1 = parseInt(d1);
    
    $( "#optional-txt1" ).html("Option1 &nbsp;&nbsp;&nbsp;"+ packs +" x P"+ <?php echo $opt[1];?> +" = P" + $optional1 );
    $total = $count + $optional1;
    $count = $total;
      $("#txtbox-total").val($total);
  }else{
    $total = $count - $optional1;
    $count = $total;
     $("#txtbox-total").val($total);
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
    var temp = packs;
    var d2 = <?php echo $opt[2];?> * temp;
    $optional2 = parseInt(d2);
    
    $( "#optional-txt2" ).html("Option2 &nbsp;&nbsp;&nbsp;"+ packs +" x P"+ <?php echo $opt[2];?> +" = P" + $optional2 );
    $total = $count + $optional2;
    $count = $total;
      $("#txtbox-total").val($total); 
  }else{
    $total = $count - $optional2;
    $count = $total;
     $("#txtbox-total").val($total);
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
    var temp = packs;
    var d3 = <?php echo $opt[3];?> * temp;
    $optional3 = parseInt(d3);
    
    $( "#optional-txt3" ).html("Option3 &nbsp;&nbsp;&nbsp;"+ packs +" x P"+ <?php echo $opt[3];?> +" = P" + $optional3 );
    $total = $count + $optional3;
    $count = $total;
      $("#txtbox-total").val($total); 
  }else{
    $total = $count - $optional3;
    $count = $total;
     $("#txtbox-total").val($total);
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
    var temp = packs;
    var d4 = <?php echo $opt[4];?> * temp;
    $optional4 = parseInt(d4);
    
    $( "#optional-txt4" ).html("Option4 &nbsp;&nbsp;&nbsp;"+ packs +" x P"+ <?php echo $opt[4];?> +" = P" + $optional4 );
    $total = $count + $optional4;
    $count = $total;
      $("#txtbox-total").val($total);
  }else{
    $total = $count - $optional4;
    $count = $total;
     $("#txtbox-total").val($total);
    $optional4 = "";
$( "#optional-txt4" ).html( $optional4 );
     
  }
});
</script>

</div><!-- END of Package-->


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
<script type="text/javascript">
function openBank(evt, bankName) {
    var i, tabcontentPax, tablinks2;
    tabcontentPax = document.getElementsByClassName("tabcontentPax");
    for (i = 0; i < tabcontentPax.length; i++) {
        tabcontentPax[i].style.display = "none";
    }
    tablinks2 = document.getElementsByClassName("tablinks2");
    for (i = 0; i < tablinks2.length; i++) {
        tablinks2[i].className = tablinks2[i].className.replace(" active", "");
    }
    document.getElementById(bankName).style.display = "block";
    evt.currentTarget.className += " active";
}
</script>