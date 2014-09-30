<?php 
if(isset($_POST['submit'])){ 
    $usr = $_POST['username']; 
    $pas = $_POST['password']; 
    if(strcmp($usr, "KomperUser") == 0 && strcmp($pas, "RepmokPass321") == 0) { 
        session_start(); 
        $_SESSION['username'] = $usr; 
        $_SESSION['logged'] = TRUE; 
        header("Location: Report.php"); // Modify to go to the page you would like 
        exit; 
    }else{ 
        header("Location: loginpage.php"); 
        exit; 
    } 
}else{    //If the form button wasn't submitted go to the index page, or login page 
    header("Location: loginpage.php");     
    exit; 
} 
?>