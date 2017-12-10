<?php
	
	require_once('class.Admin.php');
	require_once('admin.session.php');
	
	if($admin->is_loggedin()!="")
	{
		$admin->redirect('admin.actividades.php');
	}
	if(isset($_GET['logout']) && $_GET['logout']=="true")
	{
		$admin->Logout();
		$admin->redirect('index.admin.php');
	}
