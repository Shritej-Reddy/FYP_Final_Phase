
<?php
	$param = $_GET["usertext"];
	//$text = json_encode($param) ;
    echo gettype($param);
	$command1 = escapeshellcmd('python keywordextraction.py --url ' .$param);
    $output1 = shell_exec($command1);  
    //echo $output;   
    //$command = escapeshellcmd('python extract-tweet.py --url ' .$param);
    $command2 = escapeshellcmd('python extract-tweet.py --url ' .$param);
    $output2 = shell_exec($command2);
    $passv=json_encode($output2);  
    session_start(); 
    $_SESSION['varName'] = $passv;
    header("location:dbcon1.php");
?>

