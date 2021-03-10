<!DOCTYPE html>
<html>
    <head>
        <title>Profile</title>
    </head>
    <body>

    
    <?php
 
        session_start();
        $userid = $_SESSION['user'];

        $log_file = fopen("Registration.txt", "r");
        
        $data = fread($log_file, filesize("Registration.txt"));

        $data_filter = explode("\n", $data);
        
        for($i = 0; $i< count($data_filter)-1; $i++) {
            
            $json_decode = json_decode($data_filter[$i], true);
            

            if($json_decode['email'] == $userid) 
            {
                $firstname = $json_decode['firstname'];
                $lastname = $json_decode['lastname'];
                $gender = $json_decode['gender'];
                $email = $json_decode['email'];
                $image = $json_decode['image'];
            }
        }
        fclose($log_file);

        ?>

        <?php
            if($_SERVER['REQUEST_METHOD'] == "POST" && $_REQUEST['button'] == "Logout") {
                unset($_SESSION['user']); 
                header('Location: login.php');
                }
        ?>
        
        <form  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
            <input type="submit" value="Dashboard" name= "button">
            <input type="submit" value="My Order" name= "button">
            <input type="submit" value="Logout" name= "button">
        </form>

            <fieldset>
                <legend><b>Profile:</b></legend>

                <?php echo '<img src="image/'.$image.'" alt="Image" width="100" height="130">' ?>

                <br>
            
                <label for="firstname">First Name:</label>
                <?php echo $firstname; ?>

                <br>

                <label for="lastname"> LastName:</label>
                <?php echo $lastname; ?>

                <br>

                <label for="gender">Gender:  </label>
                <?php echo $gender; ?>

                <br>

                <label for="email">Email:</label>
                <?php echo $email; ?>

            </fieldset>
        
    </body>
</html>


