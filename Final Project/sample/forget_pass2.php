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
            $req_ques = $_SESSION['req_ques'];
            $req_ans = $_SESSION['req_ans'];

            $anserr = "";

            if($_SERVER['REQUEST_METHOD'] == "POST" && $_REQUEST['button'] == "Answer") {

                if(empty($_POST['ans'])) {                    
                    $anserr = "Please answer the question!";
                }
                
                else if($req_ans == $_POST['ans']){
                    header("Location: forget_pass3.php");
                }
                else {
                    $anserr = "Wrong Answer!";
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
            <label>, Here is Your Question: </label>
            <?php echo $req_ques; ?>

            <br>

            <label>Enter Your answer: </label>
            <input type="text" name="ans" id="answer">
            <input type="submit" value="Answer" name="button"> 
            <?php echo $anserr; ?>

            <br>
            <input type="submit" value="Back" name="button">
            
        </form>

        <br>



        
    </body>
</html>