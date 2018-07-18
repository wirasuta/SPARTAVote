<?php
  $baseurl = 'https://d7bb2858.ngrok.io/web/SPARTAVote/SPARTAVote/index.php';
  $loginurl = 'https://login.itb.ac.id/cas/login?service='.$baseurl;
  $res = '';
  if(isset($_GET['ticket'])){
    $ticket = $_GET['ticket'];
    $credurl = 'https://login.itb.ac.id/cas/serviceValidate?ticket='.$ticket.'&service='.$baseurl;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $credurl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($curl);
    if (!strpos($res, 'INVALID_TICKET')) {
      $resarr = explode(' ',$res);
      $nim = array_values(array_slice($resarr, -33))[0];
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
      <div id="header-row" class="row end-xs">
        <div class="col-xs-2">
          <div id="header-title" class="box"><b>GaneshaVote</b></div>
        </div>
        <?if ((!strpos($res, 'INVALID_TICKET')) && (isset($_GET['ticket']))):?>
        <div class="col-xs-10">
          <span>Logged in as <?php echo $nim;?></span>
        </div>
        <?php endif;?>
      </div>
    </div>
  </header>
  <div id="main" class="container">
  <?if ((!strpos($res, 'INVALID_TICKET')) && (isset($_GET['ticket']))): ?>
    <div class="row center-xs">
      <div class="col-xs-6">
        <img src="" alt="">
        <span>PASLON 1</span>
      </div>
      <div class="col-xs-6">
        <span>PASLON 2</span>
      </div>
    </div>
  </div>
  <div id="bottom" class="container">
    <form action="submit.php" method="post">
        <input type="submit" name="submit" value="submit">
    </form>
  </div>
  <?php else:?>
    <div class="row center-xs">
        <div class="col">
          <span>You're not logged in. Click <a href="<?php echo $loginurl;?>">here</a> to login!</span>
        </div>
    </div>
  </div>
  <?php endif;?>
</body>
</html>
