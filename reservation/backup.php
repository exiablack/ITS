<?php

function getPackage()
{
require_once("dbcontroller.php");
$db_handle = new DBController();
$_SESSION["price"] = 0;
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
  case "add":
    if(!empty($_POST["menu"])) {
    $price = $db_handle->runQuery("SELECT * FROM package WHERE pkg_name='" . $_POST["menu"] . "'");
      $_SESSION["price"] = $price[0]["pkg_price"];
      $_SESSION["package"] = $_POST["menu"];
    }
  break;


}
}
?>

<?php

$conn = mysqli_connect("localhost","root","","senordepacencia");
$menu="";

if(!$conn)
{
  /* delete mysqli_connect_error() in deployment*/
  /* mysqli_connect_error() prone to sql injection*/
  die("Connection failed: ".mysqli_connect_error());
}


  ?>

<label id= "text">Menu Package</label>
<form method="POST" action="reservationV2.php?action=add">
<select class= "menu" id= "menu" name="menu" onchange="myFunction();" value="<?php echo $menu;?>">
                 <option>--Select menu package--</option>
                 <option>Set1A</option>
                 <option>Set2A</option>
                 <option>Set3A</option>
                 <option>Set4A</option>
                 <option>Set1B</option>
                 <option>Set2B</option>
                 <option>Set3B</option>
                 <option>Set4B</option>
        </select>
        <input type="submit" name="submit" value="Go" id="go">
      
        <span><img src= "resources/star.png"/></span><div id="menu_error" class="val_error"></div>
</form>


        <div class="box-pax">
<table class="tbl-head" cellpadding="10" cellspacing="1">
<tbody>
<tr>
<th><strong>Name</strong></th>
<th><strong>Action</strong></th>
</tr> 
       </tbody>
</table>
 <table cellpadding="10" cellspacing="1">
<tbody>   
  <?php
    if(isset($_SESSION["package"])){
    $item_total = 0;
    $menu1 = $_SESSION["package"];
      $sql = "SELECT * FROM packagelist WHERE pkg_name ='$menu1' ";
      $result = $conn->query($sql);

                  if ($result->num_rows > 0) {
                       // output data of each row
                       while($row = $result->fetch_assoc()) {
                        ?>
                       <tr>
                       <td><?php echo $row["pcl_name"]."</br>";?></td>

                        <?php
                         } 

                    } else {
                      
                           } 
                              $conn->close();
                           }
                                  ?>
                             </tr>  
                        </tbody>
            </table>



        </div>
 <div class="box-pax">
          
        </div>

<h3 class="totalprice">Total Price: <span class="price"><?php echo $_SESSION["price"];?></span></h3>


  <?php
} // CLOSING OF FUNCTION getPackage()
  ?>
  <script type="text/javascript">
    function myFunction()
    {
      var menu = document.getElementById("menu");
      $menu = menu;
    }
  </script>


