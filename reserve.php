<!DOCTYPE html>
<html>
<head>
    <title>Online Reservation</title>
    <link rel="stylesheet" type="text/css" href="css/reservation.css">
    <link href="jquery/jquery-ui.css" rel="Stylesheet" type="text/css" />
    


    <script src="jquery/jquery.min.js" type="text/javascript"></script>
    <script src="jquery/jquery-ui.min.js" type="text/javascript"></script>

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
        </script>
</head>
<body>

<?php include('nav-banner.php');
?>

<div class="content-reservation">
    <div class="reservation-box">


    <br><br><br><br><br><br>
         <label id= "birthdate">Birthdate</label>

            <input type="text" id="txtDate1" name="birthdate" placeholder="Birthdate *" class="tField" >

                            <span><img src= "resources/star.png"/></span><div id="birthdate_error" class="val_error"></div>
                            <br>
    </div>
    
</div>

</body>
</html>