<?php

	require_once ('class.Admin.php');
	require_once ('admin.dbconfig.php');
	
	// if user session is not active(not loggedin) this page will help 'home.php and profile.php' to redirect to login page
	// put this file within secured pages that users (users can't access without login)	
	if(!$admin->is_loggedin())
	{
		// session no set redirects to login page
		$admin->redirect('index.admin.php');
	}