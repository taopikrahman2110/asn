<?php 

require_once 'class/class.php';

$system = new System();

if($system->IsLogged())
{
	$system->alihkan('home');
}
else
{
	$system->alihkan('login');
}
?>

