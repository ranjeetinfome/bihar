<?php

error_reporting(E_ALL);
session_start();

include('../config.php');
date_default_timezone_set(TIME_ZONE);
include('code/includes/functions.php');
include('code/includes/conn.php');

// Get page
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'login';
}

// If not on login page, needs to be logged in
if(!preg_match("/^login.*$/i", $p)){
	if(isset($_SESSION['Admin_Logged_In'])){
		if($_SESSION['Admin_Logged_In'] != 'YES'){
			header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/login');
			exit();
		}
	}else{
		header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/login');
		exit();
	}
}

$is_caller = true; //Prevent direct template access, force through __controller
$menu_selected = '';

if(isset($_SESSION['Admin_ID'])){
	include('code/includes/my_info.php');
	include('code/includes/init_info.php');
}

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

if(preg_match("/^login.*$/i", $p)){
	
	$p_option = '';
	$p_data = '';
	
	$temp = explode('/', $p);
	if(count($temp) >= 3){
		$p_option = seo($temp[1]);
		$p_data = seo($temp[2]);
	}
	
	include TEMPLATES . 'index.php';
	
}else if($p == 'dashboard'){
	
	push_recent('Dashboard', 'dashboard');
	$menu_selected = 'DASHBOARD';
	include TEMPLATES . 'dashboard.php';
	
}else if($p == 'my'){

	push_recent('My Account', 'my');
	$menu_selected = 'DASHBOARD';
	include TEMPLATES . 'my.php';
	
}else if(preg_match("/^pages.*$/i", $p)){

	if(!check_perms('pages', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/pages_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/pages_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
			case 'move':
				$temp_temp = str_replace('move-', '', $temp_data);
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/pages_process.php?data=' . $temp_temp . '&action=move');
				exit();
				break;
		}
	}
	
	push_recent('Pages', 'pages');
	$menu_selected = 'CONTENT';
	include TEMPLATES . 'pages.php';	
	
}else if(preg_match("/^faqs.*$/i", $p)){

	if(!check_perms('faqs', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$section_parent_id = 0;
	$section_type = '';

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/faqs_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/faqs_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/faqs_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
			case 'move':
				$temp_temp = str_replace('move-', '', $temp_data);
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/faqs_process.php?data=' . $temp_temp . '&action=move');
				exit();
				break;
		}
	}
	
	push_recent('FAQs', 'faqs');
	$menu_selected = 'CONTENT';
	include TEMPLATES . 'faqs.php';	
	
}else if(preg_match("/^banners.*$/i", $p)){

	if(!check_perms('banners', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$section_parent_id = 0;
	$section_type = '';

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/banners_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/banners_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/banners_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
	push_recent('Banners', 'banners');
	$menu_selected = 'CONTENT';
	include TEMPLATES . 'banners.php';	
	
}else if(preg_match("/^profiles.*$/i", $p)){

	if(!check_perms('profiles', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$section_parent_id = 0;
	$section_type = '';

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/profiles_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/profiles_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/profiles_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
	push_recent('Profiles', 'profiles');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'profiles.php';	
	
}else if(preg_match("/^promo.*$/i", $p)){

	if(!check_perms('promo', $account_permissions)){die('Unauthorised access.');}
	
	push_recent('Promo Banners', 'promo');
	$menu_selected = 'CONTENT';
	include TEMPLATES . 'promo.php';	
	
}else if(preg_match("/^directory-categories.*$/i", $p)){

	if(!check_perms('directory', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$section_parent_id = 0;

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				$temp_temp = explode('-', $temp_data);
				$section_parent_id = (int)$temp_temp[1];
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/directory_categories_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'move':
				$temp_temp = str_replace('move-', '', $temp_data);
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/directory_categories_process.php?data=' . $temp_temp . '&action=move');
				exit();
				break;
			case 'export':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/directory_categories_export.php?id=' . $listing);
				exit();
				break;
		}
	}
	
	$section_items = array(array('Directory', 'directory'), array('Directory Categories', 'directory-categories'));
	
	push_recent('Directory Categories', 'directory-categories');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'directory-categories.php';	
	
}else if(preg_match("/^directory.*$/i", $p)){

	if(!check_perms('directory', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$search_id = 0;

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				if(count($temp_temp) == 3){$search_id = (int)$temp_temp[2];}
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/directory_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/directory_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/directory_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
	$section_items = array(array('Directory', 'directory'), array('Directory Categories', 'directory-categories'));
	
	push_recent('Directory', 'directory');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'directory.php';	
	
}else if(preg_match("/^services.*$/i", $p)){

	if(!check_perms('services', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$search_id = 0;

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				if(count($temp_temp) == 3){$search_id = (int)$temp_temp[2];}
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/services_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/services_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/services_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
	$section_items = array(array('Services', 'services'));
	
	push_recent('Services', 'services');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'services.php';	
	
}else if(preg_match("/^jobs-commitments.*$/i", $p)){

	if(!check_perms('jobs', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$section_parent_id = 0;
	$section_type = '';

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/jobs_commitments_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/jobs_commitments_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/jobs_commitments_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
	$section_items = array(array('Jobs', 'jobs'), array('Job Commitments', 'jobs-commitments'), array('Job Industries', 'jobs-industries'));
	
	push_recent('Job Commitments', 'jobs-commitments');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'jobs-commitments.php';	
	
}else if(preg_match("/^jobs-industries.*$/i", $p)){

	if(!check_perms('jobs', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$section_parent_id = 0;
	$section_type = '';

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/jobs_industries_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/jobs_industries_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/jobs_industries_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
	$section_items = array(array('Jobs', 'jobs'), array('Job Commitments', 'jobs-commitments'), array('Job Industries', 'jobs-industries'));
	
	push_recent('Job Industries', 'jobs-industries');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'jobs-industries.php';	
	
}else if(preg_match("/^jobs.*$/i", $p)){

	if(!check_perms('jobs', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$search_id = 0;

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				if(count($temp_temp) == 3){$search_id = (int)$temp_temp[2];}
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/jobs_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/jobs_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/jobs_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
	$section_items = array(array('Jobs', 'jobs'), array('Job Commitments', 'jobs-commitments'), array('Job Industries', 'jobs-industries'));
	
	push_recent('Jobs', 'jobs');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'jobs.php';	
	
}else if(preg_match("/^motors-makes.*$/i", $p)){

	if(!check_perms('motors', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$section_parent_id = 0;

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				$temp_temp = explode('-', $temp_data);
				$section_parent_id = (int)$temp_temp[1];
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/motors_makes_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'move':
				$temp_temp = str_replace('move-', '', $temp_data);
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/motors_makes_process.php?data=' . $temp_temp . '&action=move');
				exit();
				break;
			case 'export':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/motors_makes_process.php?id=' . $listing);
				exit();
				break;
		}
	}
	
$section_items = array(array('Motors', 'motors'), array('Motor Colours', 'motors-colours'), array('Makes &amp; Models', 'motors-makes'),array('Makes Type', 'motors-type'));
	
	push_recent('Makes &amp; Models', 'motors-makes');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'motors-makes.php';	
	
}else if(preg_match("/^motors-colours.*$/i", $p)){

	if(!check_perms('motors', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$section_parent_id = 0;
	$section_type = '';

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/motors_colours_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/motors_colours_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/motors_colours_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
$section_items = array(array('Motors', 'motors'), array('Motor Colours', 'motors-colours'), array('Makes &amp; Models', 'motors-makes'),array('Makes Type', 'motors-type'));

	push_recent('Motor Colours', 'motors-colours');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'motors-colours.php';	
	
}else if(preg_match("/^motors-type.*$/i", $p)){

	if(!check_perms('motors', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$section_parent_id = 0;
	$section_type = '';

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/motors_type_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/motors_type_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/motors_type_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
$section_items = array(array('Motors', 'motors'), array('Motor Colours', 'motors-colours'), array('Makes &amp; Models', 'motors-makes'),array('Makes Type', 'motors-type'));
	
	push_recent('Motor Type', 'motors-type');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'motors-type.php';	
	
}else if(preg_match("/^motors.*$/i", $p)){

	if(!check_perms('motors', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$search_id = 0;

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				if(count($temp_temp) == 3){$search_id = (int)$temp_temp[2];}
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/motors_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/motors_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/motors_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
$section_items = array(array('Motors', 'motors'), array('Motor Colours', 'motors-colours'), array('Makes &amp; Models', 'motors-makes'),array('Makes Type', 'motors-type'));
	
	push_recent('Motors', 'motors');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'motors.php';	
	
}else if(preg_match("/^properties-amenities.*$/i", $p)){

	if(!check_perms('properties', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$section_parent_id = 0;
	$section_type = '';

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/properties_amenities_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/properties_amenities_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/properties_amenities_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
	$section_items = array(array('Properties', 'properties'), array('Property Amenities', 'properties-amenities'), array('Property Types', 'properties-types'),array('Property Categories', 'properties-categories'), array('Property Views', 'properties-views'));
	
	push_recent('Property Amenities', 'properties-amenities');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'properties-amenities.php';	
	
}else if(preg_match("/^properties-views.*$/i", $p)){

	if(!check_perms('properties', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$section_parent_id = 0;
	$section_type = '';

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/properties_views_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/properties_views_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/properties_views_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
	$section_items = array(array('Properties', 'properties'), array('Property Amenities', 'properties-amenities'), array('Property Types', 'properties-types'),array('Property Categories', 'properties-categories'), array('Property Views', 'properties-views'));
	
	push_recent('Property Views', 'properties-views');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'properties-views.php';	
	
}else if(preg_match("/^properties-types.*$/i", $p)){

	if(!check_perms('properties', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$section_parent_id = 0;
	$section_type = '';

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				$temp_temp = explode('-', $temp_data);
				$section_parent_id = (int)$temp_temp[1];
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/properties_types_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/properties_types_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/properties_types_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
			case 'move':
				$temp_temp = str_replace('move-', '', $temp_data);
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/properties_types_process.php?data=' . $temp_temp . '&action=move');
				exit();
				break;
		}
	}
	
	$section_items = array(array('Properties', 'properties'), array('Property Amenities', 'properties-amenities'), array('Property Types', 'properties-types') ,array('Property Categories', 'properties-categories'),array('Property Views', 'properties-views'));
	
	push_recent('Property Types', 'properties-types');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'properties-types.php';	
	
}else if(preg_match("/^properties-categories.*$/i", $p)){

	if(!check_perms('properties', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$section_parent_id = 0;
	$section_type = '';

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				$temp_temp = explode('-', $temp_data);
				$section_parent_id = (int)$temp_temp[1];
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/properties_categories_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/properties_categories_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/properties_categories_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
			case 'move':
				$temp_temp = str_replace('move-', '', $temp_data);
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/properties_categories_process.php?data=' . $temp_temp . '&action=move');
				exit();
				break;
		}
	}
	
	$section_items = array(array('Properties', 'properties'), array('Property Amenities', 'properties-amenities'), array('Property Types', 'properties-types'),array('Property Categories', 'properties-categories'), array('Property Views', 'properties-views'));
	
	push_recent('Property Categories', 'properties-categories');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'properties-categories.php';	
	
}else if(preg_match("/^properties.*$/i", $p)){

	if(!check_perms('properties', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$search_id = 0;

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				if(count($temp_temp) == 3){$search_id = (int)$temp_temp[2];}
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/properties_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/properties_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/properties_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
	$section_items = array(array('Properties', 'properties'), array('Property Amenities', 'properties-amenities'), array('Property Types', 'properties-types'),array('Property Categories', 'properties-categories'), array('Property Views', 'properties-views'));
	
	push_recent('Properties', 'properties');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'properties.php';	
	
}else if(preg_match("/^restaurants-dresscodes.*$/i", $p)){

	if(!check_perms('restaurants', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$section_parent_id = 0;
	$section_type = '';

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/restaurants_dresscodes_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/restaurants_dresscodes_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/restaurants_dresscodes_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
	$section_items = array(array('Restaurants', 'restaurants'), array('Restaurant Cuisines', 'restaurants-cuisines'), array('Restaurant Dress Codes', 'restaurants-dresscodes'), array('Restaurant Menus', 'restaurants-menus'));
	
	push_recent('Restaurant Dress Codes', 'restaurants-dresscodes');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'restaurants-dresscodes.php';	
	
}else if(preg_match("/^restaurants-cuisines.*$/i", $p)){

	if(!check_perms('restaurants', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$section_parent_id = 0;
	$section_type = '';

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/restaurants_cuisines_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/restaurants_cuisines_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/restaurants_cuisines_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
	$section_items = array(array('Restaurants', 'restaurants'), array('Restaurant Cuisines', 'restaurants-cuisines'), array('Restaurant Dress Codes', 'restaurants-dresscodes'), array('Restaurant Menus', 'restaurants-menus'));
	
	push_recent('Restaurant Cuisines', 'restaurants-cuisines');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'restaurants-cuisines.php';	
	
}else if(preg_match("/^restaurants-menus.*$/i", $p)){

	if(!check_perms('restaurants', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$section_parent_id = 0;
	$section_type = '';

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/restaurants_menus_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/restaurants_menus_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/restaurants_menus_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
	$section_items = array(array('Restaurants', 'restaurants'), array('Restaurant Cuisines', 'restaurants-cuisines'), array('Restaurant Dress Codes', 'restaurants-dresscodes'), array('Restaurant Menus', 'restaurants-menus'));
	
	push_recent('Restaurant Menus', 'restaurants-menus');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'restaurants-menus.php';	
	
}else if(preg_match("/^restaurants.*$/i", $p)){

	if(!check_perms('restaurants', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$search_id = 0;

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				if(count($temp_temp) == 3){$search_id = (int)$temp_temp[2];}
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/restaurants_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/restaurants_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/restaurants_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
	$section_items = array(array('Restaurants', 'restaurants'), array('Restaurant Cuisines', 'restaurants-cuisines'), array('Restaurant Dress Codes', 'restaurants-dresscodes'), array('Restaurant Menus', 'restaurants-menus'));
	
	push_recent('Restaurants', 'restaurants');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'restaurants.php';	
	
}else if(preg_match("/^accommodation-facilities.*$/i", $p)){

	if(!check_perms('accommodation', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$section_parent_id = 0;
	$section_type = '';

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/accommodation_facilities_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/accommodation_facilities_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/accommodation_facilities_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
	$section_items = array(array('Accommodation', 'accommodation'), array('Accommodation Facilities', 'accommodation-facilities'), array('Accommodation Types', 'accommodation-types'));
	
	push_recent('Accommodation Facilities', 'accommodation-facilities');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'accommodation-facilities.php';	
	
}else if(preg_match("/^accommodation-types.*$/i", $p)){

	if(!check_perms('accommodation', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$section_parent_id = 0;
	$section_type = '';

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/accommodation_types_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/accommodation_types_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/accommodation_types_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
	$section_items = array(array('Accommodation', 'accommodation'), array('Accommodation Facilities', 'accommodation-facilities'), array('Accommodation Types', 'accommodation-types'));
	
	push_recent('Accommodation Types', 'accommodation-types');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'accommodation-types.php';	
	
}else if(preg_match("/^accommodation.*$/i", $p)){

	if(!check_perms('accommodation', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$search_id = 0;

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				if(count($temp_temp) == 3){$search_id = (int)$temp_temp[2];}
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/accommodation_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/accommodation_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/accommodation_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
	$section_items = array(array('Accommodation', 'accommodation'), array('Accommodation Facilities', 'accommodation-facilities'), array('Accommodation Types', 'accommodation-types'));
	
	push_recent('Accommodation', 'accommodation');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'accommodation.php';	
	
}else if(preg_match("/^events-types.*$/i", $p)){

	if(!check_perms('events', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$section_parent_id = 0;
	$section_type = '';

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/events_types_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/events_types_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/events_types_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
	$section_items = array(array('Events', 'events'), array('Event Types', 'events-types'));
	
	push_recent('Event Types', 'events-types');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'events-types.php';		
	
}else if(preg_match("/^events.*$/i", $p)){

	if(!check_perms('events', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$search_id = 0;

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				if(count($temp_temp) == 3){$search_id = (int)$temp_temp[2];}
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/events_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/events_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/events_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
	$section_items = array(array('Events', 'events'), array('Event Types', 'events-types'));
	
	push_recent('Events', 'events');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'events.php';	
	
}else if(preg_match("/^recycle-categories.*$/i", $p)){

	if(!check_perms('recycle', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$section_parent_id = 0;
	$section_type = '';

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/recycle_categories_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/recycle_categories_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/recycle_categories_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
	$section_items = array(array('Recycle', 'recycle'), array('Recycle Categories', 'recycle-categories'), array('Recycle Conditions', 'recycle-conditions'));
	
	push_recent('Recycle Categories', 'recycle-categories');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'recycle-categories.php';	
	
}else if(preg_match("/^recycle-conditions.*$/i", $p)){

	if(!check_perms('recycle', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$section_parent_id = 0;
	$section_type = '';

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/recycle_conditions_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/recycle_conditions_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/recycle_conditions_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
	$section_items = array(array('Recycle', 'recycle'), array('Recycle Categories', 'recycle-categories'), array('Recycle Conditions', 'recycle-conditions'));
	
	push_recent('Recycle Conditions', 'recycle-conditions');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'recycle-conditions.php';	
	
}else if(preg_match("/^recycle.*$/i", $p)){

	if(!check_perms('recycle', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table
	$search_id = 0;

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				if(count($temp_temp) == 3){$search_id = (int)$temp_temp[2];}
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/recycle_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/recycle_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/recycle_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
		}
	}
	
	$section_items = array(array('Recycle', 'recycle'), array('Recycle Categories', 'recycle-categories'), array('Recycle Conditions', 'recycle-conditions'));
	
	push_recent('Recycle', 'recycle');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'recycle.php';	
	
}else if(preg_match("/^locations.*$/i", $p)){

	if(!check_perms('locations', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$item_parent_id = 0;
	$listing_form = false; // Show form instead of listing table

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$temp_temp = explode('-', $temp_data);
				$item_parent_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/locations_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
		}
	}
	
	push_recent('Locations', 'locations');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'locations.php';	
	
}else if($p == 'content'){
	
	if(!check_perms('content', $account_permissions)){die('Unauthorised access.');}
	
	push_recent('Content', 'content');
	$menu_selected = 'CONTENT';
	include TEMPLATES . 'content.php';
	
}else if($p == 'listings'){
	
	if(!check_perms('listings', $account_permissions)){die('Unauthorised access.');}
	
	push_recent('Listings', 'listings');
	$menu_selected = 'LISTINGS';
	include TEMPLATES . 'listings.php';
	
}else if(preg_match("/^categories.*$/i", $p)){

	if(!check_perms('categories', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/categories_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/categories_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/categories_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
			case 'move':
				$temp_temp = str_replace('move-', '', $temp_data);
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/categories_process.php?data=' . $temp_temp . '&action=move');
				exit();
				break;
		}
	}
	
	push_recent('Categories', 'categories');
	$menu_selected = 'AWARDS';
	include TEMPLATES . 'categories.php';	
	
}else if($p == 'system'){
	
	if(!check_perms('system', $account_permissions)){die('Unauthorised access.');}
	
	push_recent('System', 'system');
	$menu_selected = 'SYSTEM';
	include TEMPLATES . 'system.php';
	
}else if(preg_match("/^users.*$/i", $p)){

	if(!check_perms('users', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/users_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/users_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/users_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
		}
	}
	
	push_recent('Admin Accounts', 'users');
	$menu_selected = 'SYSTEM';
	include TEMPLATES . 'users.php';	
	
}else if(preg_match("/^logs-security.*$/i", $p)){

	if(!check_perms('logs_security', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'clear':
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/logs_security_process.php?action=clear');
				exit();
				break;
		}
	}
	
	push_recent('Security Logs', 'logs-security');
	$menu_selected = 'SYSTEM';
	include TEMPLATES . 'logs_security.php';	
	
}else if(preg_match("/^logs-activity.*$/i", $p)){

	if(!check_perms('logs_activity', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'clear':
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/logs_activity_process.php?action=clear');
				exit();
				break;
		}
	}
	
	push_recent('Activity Logs', 'logs-activity');
	$menu_selected = 'SYSTEM';
	include TEMPLATES . 'logs_activity.php';	
	
}else if(preg_match("/^gallery-albums.*$/i", $p)){

	if(!check_perms('gallery', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/gallery_albums_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
		}
	}
	
	$section_items = array(array('Gallery', 'gallery'), array('Gallery Albums', 'gallery-albums'));
	
	push_recent('Gallery Albums', 'gallery-albums');
	$menu_selected = 'CONTENT';
	include TEMPLATES . 'gallery_albums.php';	
	
}else if(preg_match("/^gallery.*$/i", $p)){

	if(!check_perms('gallery', $account_permissions)){die('Unauthorised access.');}

	$page = 1;
	$album = 0;
	$listing_id = 0;
	$listing_form = false; // Show form instead of listing table

	$temp = explode('/', $p);
	if(count($temp) >= 2){
		$temp_data = $temp[1];
		$temp_2 = explode('-', $temp_data);
		switch($temp_2[0]){
			case 'page':
				$temp_temp = explode('-', $temp_data);
				$page = (int)$temp_temp[1];
				if(isset($temp_temp[2])){
					$album = (int)$temp_temp[2];
				}
				break;
			case 'edit':
				$temp_temp = explode('-', $temp_data);
				$listing_id = (int)$temp_temp[1];
				$listing_form = true;
				break;
			case 'add':
				$listing_form = true;
				break;
			case 'deactivate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/gallery_process.php?id=' . $listing . '&action=deactivate');
				exit();
				break;
			case 'activate':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/gallery_process.php?id=' . $listing . '&action=activate');
				exit();
				break;
			case 'delete':
				$temp_temp = explode('-', $temp_data);
				$listing = (int)$temp_temp[1];
				header('Location: ' . COMPANY_URL . '' . SYSTEM_ADMIN_FOLDER . '/code/includes/gallery_process.php?id=' . $listing . '&action=delete');
				exit();
				break;
		}
	}
	
	$section_items = array(array('Gallery', 'gallery'), array('Gallery Albums', 'gallery-albums'));
	
	push_recent('Gallery', 'gallery');
	$menu_selected = 'CONTENT';
	include TEMPLATES . 'gallery.php';	
	
}else if($p == 'settings'){
	
	if(!check_perms('settings', $account_permissions)){die('Unauthorised access.');}
	
	push_recent('Settings', 'settings');
	$menu_selected = 'SYSTEM';
	include TEMPLATES . 'settings.php';
	
}else if($p == 'logout'){

	include TEMPLATES . 'logout.php';
	
}else{

	die('Not found.');
	
}

?>