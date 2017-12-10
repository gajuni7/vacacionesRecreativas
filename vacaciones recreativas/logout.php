<?php
	
	require_once('class.user.php');
	require_once('session.php');
	
	if($user->is_loggedin()!="")
	{
		$user->redirect('home.php');
	}
	if(isset($_GET['logout']) && $_GET['logout']=="true")
	{
		$user->Logout();
		$user->redirect('index.php');
	}
