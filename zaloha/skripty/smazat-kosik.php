<?
//ini_set('session.save_path', "../tmp_sess");
session_start();
unset($_SESSION["kosik"]);
header("Location: ".$_SERVER['HTTP_REFERER']);
exit();	
?>
