<?php
$adminmenu = array();
$icon_dir=substr(XOOPS_VERSION,6,3)=='2.6'?"":"images/";

$i = 1;
$adminmenu[$i]['title'] = _MI_TAD_ADMIN_HOME ;
$adminmenu[$i]['link'] = 'admin/index.php' ;
$adminmenu[$i]['desc'] = _MI_TAD_ADMIN_HOME_DESC ;
$adminmenu[$i]['icon'] = 'images/admin/home.png' ;

$i++;
$adminmenu[$i]['title'] = _MI_ESEXAM_ADMENU1;
$adminmenu[$i]['link'] = "admin/main.php";
$adminmenu[$i]['desc'] = _MI_ESEXAM_ADMENU1 ;
$adminmenu[$i]['icon'] = "images/admin/list_all_participants.png";

$i++;
$adminmenu[$i]['title'] = _MI_ESEXAM_ADMENU2;
$adminmenu[$i]['link'] = "admin/add.php";
$adminmenu[$i]['desc'] = _MI_ESEXAM_ADMENU2 ;
$adminmenu[$i]['icon'] = "images/admin/add1.png";
 
 
$i++;
$adminmenu[$i]['title'] = '評分';
$adminmenu[$i]['link'] = "admin/score.php";
$adminmenu[$i]['desc'] = '成績處理' ;
$adminmenu[$i]['icon'] = "images/admin/gnome_mime_application_x_archive.png";
 

$i++;
$adminmenu[$i]['title'] = _MI_TAD_ADMIN_ABOUT;
$adminmenu[$i]['link'] = 'admin/about.php';
$adminmenu[$i]['desc'] = _MI_TAD_ADMIN_ABOUT_DESC;
$adminmenu[$i]['icon'] = 'images/admin/about.png';

?>
