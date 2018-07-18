<?php
  $baseurl = 'https://af20890f.ngrok.io/web/UjiINA/uji1.php';
  if(isset($_GET['ticket'])){
    $ticket = $_GET['ticket'];
    echo('Ticket is '.$ticket.' <br>');
    #$url = 'https://akademik.itb.ac.id/login/INA?ticket='.$ticket;
    #$url = 'https://nic.itb.ac.id/cas?ticket='.$ticket;
    #$url = 'https://nic.itb.ac.id/manajemen-akun/pengecekan-user?ticket='.$ticket;
    $url = 'https://login.itb.ac.id/cas/serviceValidate?ticket='.$ticket.'&service='.$baseurl;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($curl);
    echo($res);
    curl_close($curl);
  }else{
    die('Nothing');
  };
?>
