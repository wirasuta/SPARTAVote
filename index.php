<?php
  $baseurl = "https://d7bb2858.ngrok.io/web/SPARTAVote/SPARTAVote/index.php";
  $loginurl = "https://login.itb.ac.id/cas/login?service=".$baseurl;
  $res = "";
  if(isset($_GET["ticket"])){
    $ticket = $_GET["ticket"];
    $credurl = "https://login.itb.ac.id/cas/serviceValidate?ticket=".$ticket."&service=".$baseurl;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $credurl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($curl);
    if (!strpos($res, "INVALID_TICKET")) {
      $resarr = explode(" ",$res);
      $tmnim = array_values(array_slice($resarr, -33))[0];
      $nim = explode("<",explode(">",$tmnim)[1])[0];
    }
    curl_close($curl);
  }
?>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Ganesha Vote</title>
  <link rel="stylesheet" type="text/css" href="css/flexboxgrid.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <header>
    <div class="container">
      <div class="row end-xs" id="header-row" >
        <div class="col-xs-2">
          <div class="box" id="header-title" ><b>GaneshaVote</b></div>
        </div>
        <div class="col-xs-10">
        <?if ((!strpos($res, "INVALID_TICKET")) && (isset($_GET["ticket"]))):?>
          <span>Logged in as <?php echo $nim;?></span>
        <?php endif;?>
        </div>
      </div>
    </div>
  </header>
  <div class="container" id="main">
  <?if ((!strpos($res, "INVALID_TICKET")) && (isset($_GET["ticket"]))): ?>
    <div class="row center-xs votebox">
      <div class="col-xs-6">
        <div class="box">
          <img src="example-res/face1.png" class="fotopaslon"><br>
          <span>AGUS DOE</span>
        </div>
      </div>
      <div class="col-xs-6">
        <div class="box">
          <img src="example-res/face2.jpeg" class="fotopaslon"><br>
          <span>JOHN FULAN</span>
        </div>
      </div>
    </div>
    <form action="submit.php" method="post">
      <div class="row center-xs votebox">
        <div class="col-xs-6">
          <input type="radio" name="choice" value="1"><b>PASLON 1</b>
        </div>
        <div class="col-xs-6">
          <input type="radio" name="choice" value="2"><b>PASLON 2</b>
        </div>
      </div>
      <div class="row center-xs votebox">
        <div class="col">
          <input type="hidden" name="nim" value="<?php echo $nim;?>">
          <input type="hidden" name="ticket" value="<?php echo $ticket;?>">
          <input type="submit">
        </div>
      </div>
    </form>
  </div>
  <?php else:?>
    <div class="row center-xs">
        <div class="col">
          <span>You"re not logged in. Click <a href="<?php echo $loginurl;?>">here</a> to login!</span>
        </div>
    </div>
  </div>
  <?php endif;?>
</body>
</html>
