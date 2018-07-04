<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   

    <title>Registration</title>

    <style>
        @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro');
    </style>

    <link rel="stylesheet" media="all" type="text/css" href="Cs/bootstrap-3.3.7-dist/css/bootstrap.min.css" />
    <link rel="stylesheet" media="all" type="text/css" href="Style.css" />
    <script src="js/jquery-3.2.1.min.js"></script>
    
    
</head>

<body>

    <?php
    
    /*
    CREATE TABLE regi(
	id int AUTO_INCREMENT PRIMARY KEY,
    urname varchar(50) NOT NULL,
    email varchar(80) NOT NULL,
    passwd varchar(50) NOT NULL,
    fname varchar(50) NOT NULL,
    gender varchar(10) NOT NULL   
);
    */
        $urerr = $eerr = $perr = $cperr = $fnerr = $gerr = " ";
        $urname = $email = $passwd = $name = $gender = "";
    
        $boolen  = false;
       
    
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            
            if(empty($_POST["urname"])){
               $urerr = "Username Required...!";
                $boolen  = false;
            }else{
               $urname = validate_input($_POST["urname"]);
                $boolen  = true;
            }
            
            if(empty($_POST["email"])){
                $eerr = "Email Required...!";
                $boolen  = false;
            }elseif(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
                $eerr = "Invalid Email...!";
                $boolen  = false;
            }else{
                $email = validate_input($_POST["email"]);
                $boolen  = true;
            }
            
            $lenght = strlenght($_POST["passwd"]);
            
            if(empty($_POST["passwd"])){
                $perr = "Password Field Required...!";
                $boolen  = false;
            }elseif($lenght){
                $perr = $lenght;
                $boolen  = false;
            }else{
                    $passwd = validate_input($_POST["passwd"]);
                $boolen  = true;
            }
            
            
            if(empty($_POST["cpasswd"])){
                $cperr = "Confirm Password Required...!";
                $boolen  = false;
            }
            elseif($_POST["cpasswd"]!=$passwd){
                $cperr = "Password Not Match...!";
                $boolen  = false;
            }
            
            if(empty($_POST["fname"]) || empty($_POST["lname"])){
                $fnerr = "First & Last Name Required...!";
                $boolen  = false;
            }else{
                $name = validate_input($_POST["fname"]);
                $boolen  = true;
            }
            
            if(empty($_POST["gender"])){
                $gerr = "Gender Required...!";
                $boolen  = false;
            }else{
                $gender = validate_input($_POST["gender"]);
                $boolen  = true;
            }
            
            if(isset($_POST["ck1"])){
                $boolen  = true;
            }else{
                $boolen  = false;  
            }
     } 
        function strlenght($str){
            $ln = strlen($str);
            if($ln > 15){
                return "Passwod should less than 15 charecter";
            }elseif($ln < 5 && $ln >= 1){
                return "Password should greater then 3 charecter";
            }
            return;
        }
        function validate_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
      
    
        if($boolen){
            
             $dbname = "regdb";
                $con = mysqli_connect("localhost","root","",$dbname);

            if(!$con){
                    die("Connection Failed :" + mysqli_connect_error());
                }
            
            function NewUser(){
                $sql = "INSERT INTO regi (urname,email,passwd,fname,gender) VALUES ('$_POST[urname]','$_POST[email]','$_POST[passwd]','$_POST[fname]','$_POST[gender]')";
                
                $query = mysqli_query($GLOBALS['con'],$sql);
                
                if($query){
                    echo "<script>
                        alert ('Record Inserted Successfully...!');
                    </script>";
                }
            }
            
            function SignUP(){
                $sql = "SELECT * FROM regi WHERE urname = '$_POST[urname]' AND email = '$_POST[email]'";
                
                $result = mysqli_query($GLOBALS['con'],$sql);
                
                if(!$row = mysqli_fetch_array($result)){
                    NewUser();
                }else{
                    echo "<script>
                        alert ('You Are Already Registered User......!');
                    </script>";
                }
            }
            
            if(isset($_POST["submit"])){
                
                SignUp();
                mysqli_close($GLOBALS["con"]);
                $boolen = false;
            }    
        }
    ?>
    <form method="post" enctype="multipart/form-data" action="<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

        <div class="container">
            <div class="inner">

                <div class="title">
                    <h3>Registration Form</h3>
                </div>
                      
                <div class="content">
                    <div class="txt">
                        <input type="text" id="txtuser" name="urname" placeholder="Username">
                        <span id="c1" class="glyphicon glyphicon-user"></span>
                    </div>
                       <span id="span"><?php echo $urerr; ?></span>
                    <div class="txt1">
                        <input type="text" id="txtemail" name="email" placeholder="Email Address">
                        <span id="c2" class="glyphicon glyphicon-envelope"></span>
                    </div>
                        <span id="span"><?php echo $eerr; ?></span>
                    <div class="txt1">
                        <input type="password" id="txtpass" name="passwd" placeholder="Password">
                        <span id="c3" class="glyphicon glyphicon-lock"></span>
                    </div>
                        <span id="span"><?php echo $perr; ?></span>
                    <div class="txt1">
                        <input type="password" id="txtcpass" name="cpasswd" placeholder="Confirm Password">
                        <span id="c4" class="glyphicon glyphicon-lock"></span>
                    </div>
                        <span id="span"><?php echo $cperr; ?></span>
                </div>
                
                 <div class="content2">
                    <input type="text" id="txtfname" name="fname" placeholder="First Name">
                    <input type="text" id="txtlname" name="lname" placeholder="Last Name">
                </div>
                <span id="span"><?php echo $fnerr; ?></span>
                    
                <div class="radios">
                    <h4>Gender :</h4>
                    <input type="radio" value="Male" name="gender">
                    <label>Male</label>
                    <input type="radio" value="Female" name="gender">
                    <label for="">Female</label>
                </div>
                   <span id="span"><?php echo $gerr; ?></span>
                
                <div class="ckbox">
                    <input type="checkbox" id="ckbox1" name="ck1">
                    <span>I Agree to Teams and Service</span>
                    <br>
                    <input type="checkbox" id="ckbox2" name="ck2">
                    <span>I Want to receive news and special offers</span>
                </div>

                <div class="btnsub">
                    <input type="submit" name="submit" id="btnsub" value="Submit">
                </div>
            </div> 

        </div>      
    </form>
    
  
    <script>
        $(document).ready(function() {
            var icon = "";
            var $txt1 = $("#txtuser");
            var $txt2 = $("#txtemail");
            var $txt3 = $("#txtpass");
            var $txt4 = $("#txtcpass");
            
            $("input").focus(function() {
                var id = document.activeElement.id;
                if (id == "txtuser") {
                    $("#c1").css("color", "green");
                    icon = "#c1";
                }
                if (id == "txtemail") {
                    $("#c2").css("color", "green");
                    icon = "#c2";
                }
                if (id == "txtpass") {
                    $("#c3").css("color", "green");
                    icon = "#c3";
                }
                if (id == "txtcpass") {
                    $("#c4").css("color", "green");
                    icon = "#c4";
                }
            });
            $("input").blur(function() {

                $(icon).css("color", "#b2b2b2");

                if ($txt1.val() != "")
                    $("#c1").css("color", "green");

                if ($txt2.val() != "")
                    $("#c2").css("color", "green");

                if ($txt3.val() != "")
                    $("#c3").css("color", "green");

                if ($txt4.val() != "")
                    $("#c4").css("color", "green");
            });    
        });
    </script>
</body>
</html>