<?php
#DATABASE CREDENTIALS#
$servername = "localhost";
$dbname = "phpsandbox";
$username = "root";
$password = "12345";

  if(isset($_POST["choice"]) && isset($_POST["nim"]) && isset($_POST["ticket"])){
    #CONNECT TO DATABASE WITH PDO#
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
      echo "Connection failed: " . $e->getMessage();
    }

    #ASSUMING VOTE DATABASE EXISTED WITH ROW#
    #ID (AutoInc), DATETIME (CurrDate), NIM, SSOTICKET, VOTE#
    $insquery = "INSERT INTO votetable(nim,ssoticket,vote) VALUE (:nim,:ssoticket,:vote)";
    $ins = $conn -> prepare($insquery);
    $chkquery = "SELECT * FROM votetable WHERE nim = :nim";
    $chk = $conn->prepare($chkquery);

    $chk->bindValue(":nim", $nim, PDO::PARAM_STR);
    $chk->execute();
    if (($chk->rowCount()) === 0) {
      $ins->bindValue(":nim", $nim,PDO::PARAM_STR);
      $ins->bindValue(":ssoticket", $ticket,PDO::PARAM_STR);
      $ins->bindValue(":ssoticket", $choice,PDO::PDO::PARAM_INT);
      $ins->execute();
      echo "Vote from ".$nim."has been recorded succesfully";
    }else{
      die("You have voted before. Only one vote per person");
    }
  }else{
    die("Submission failed! Please try again in a few moments");
  }
?>
