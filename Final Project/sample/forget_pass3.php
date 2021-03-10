<!DOCTYPE html>
<html>
    <head>
        <title>Account Recovery</title>
    </head>
    <body>
        <?php

            session_start();
            $gmail = $_SESSION['gmail'];            
            $name = $_SESSION['name'];

            $emptyerr = $passerr = "";


            if($_SERVER['REQUEST_METHOD'] == "POST" && $_REQUEST['button'] == "Change Password") {

                if(empty($_POST['pass']) || empty($_POST['cpass'])) {
                    $emptyerr = "Please Fill up the form properly!";
                }

                else if($_POST['pass'] != $_POST['cpass']) {
                    $passerr="Password doesn't Match";
                }

                else if(strlen($_POST['pass']) <= 7) {
                    $passerr="Password Must be minimum 8 character!";
                }
                else {

                    $log_file = fopen("Login.txt", "r");
                    
                    $data = fread($log_file, filesize("Login.txt"));
                    
                    fclose($log_file);
                    
                    $data_filter = explode("\n", $data);
                    
                    $log_filepath = "Temp.txt";

                    $log_file = fopen($log_filepath, "a");

                    for($i = 0; $i< count($data_filter)-1; $i++) {
                        $json_decode = json_decode($data_filter[$i], true);
                        if($json_decode['username'] == $gmail) 
                        {
                            $usertable = array('username' => $gmail, 'password' => $_POST['pass']);
                            $usertable_encoded = json_encode($usertable);
                            fwrite($log_file, $usertable_encoded . "\n");
                        }
                        else {
                            $usertable_encoded = json_encode($json_decode);
                            fwrite($log_file, $usertable_encoded . "\n");	
                        } 
                    }
                    fclose($log_file);

                    $log_file = fopen("Temp.txt", "r");                    
                    $data = fread($log_file, filesize("Temp.txt"));                    
                    fclose($log_file);

                    $log_file = fopen("Login.txt", "w");
                    fwrite($log_file, $data);                    
                    fclose($log_file);

                    $log_file = fopen("Temp.txt", "w");
                    fwrite($log_file, "");                    
                    fclose($log_file);
                    
                    unset($_SESSION['gmail']);
                    unset($_SESSION['name']); 
                    unset($_SESSION['req_ques']);  
                    unset($_SESSION['req_ans']); 
                    
                    header("Location: login.php");
                }
            }

            if($_SERVER['REQUEST_METHOD'] == "POST" && $_REQUEST['button'] == "Back") {
                unset($_SESSION['gmail']);
                unset($_SESSION['name']);
                unset($_SESSION['req_ques']);
                unset($_SESSION['req_ans']);
                header('Location: login.php');
            
            }
        ?>
        
        <h3>Recover Your Account!</h3>
        <form  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
            
            <label>Mr/Mrs.</label>
            <?php echo $name; ?>
            <label>, Enter Your new Password! </label>

            <br>

            <label for="password">Password:</label>
            <input type="password" name="pass" id="password">

            <br>

            <label for="cpassword">Confirm Password:</label>
            <input type="password" name="cpass" id="cpassword">
            <?php echo $passerr; ?>

            <br>

            <?php echo $emptyerr; ?>

            <br>

            <input type="submit" value="Change Password" name="button"> 

            <br>

            <input type="submit" value="Back" name="button">
            
        </form>

        <br>
         
    </body>
</html>