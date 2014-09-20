<?php
$modversion = array();

//---模組基本資訊---//
$modversion['name'] = _MI_ESEXAM_NAME;
$modversion['version'] = 0.4;
$modversion['description'] = _MI_ESEXAM_DESC;
$modversion['author'] = _MI_ESEXAM_AUTHOR;
$modversion['credits'] = _MI_ESEXAM_CREDITS;
$modversion['help'] = 'page=help';
$modversion['license'] = 'GNU GPL 2.0';
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['image'] = "images/logo.png";
$modversion['dirname'] = basename(dirname(__FILE__));

//---模組狀態資訊---//
$modversion['release_date'] = '2014/7/01';
$modversion['module_website_url'] = 'https://github.com/prolin99/es_exam';
$modversion['module_website_name'] = "prolin";
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = 'https://github.com/prolin99/es_exam';
$modversion['author_website_name'] = "prolin";
$modversion['min_php']=5.2;
$modversion['min_xoops']='2.5';
$modversion['min_tadtools']='2.02';
/*
//---paypal資訊---//
$modversion ['paypal'] = array();
$modversion ['paypal']['business'] = 'prolin99@gmail.com';
$modversion ['paypal']['item_name'] = 'Donation : ' . _MI_TAD_WEB;
$modversion ['paypal']['amount'] = 0;
$modversion ['paypal']['currency_code'] = 'USD';
*/

//---資料表架構---//
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][1] = "exam";
$modversion['tables'][2] = "exam_files";
//$modversion['tables'][3] = "es_exam_types";

//---啟動後台管理界面選單---//
$modversion['system_menu'] = 1;

//---安裝設定---//
$modversion['onInstall'] = "include/onInstall.php";
$modversion['onUninstall'] = "include/onUninstall.php";



//---管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

//---使用者主選單設定---//
$modversion['hasMain'] = 1;



//---樣板設定---//
$i=1;
$modversion['templates'][$i]['file'] = 'es_exam_index.html';
$modversion['templates'][$i]['description'] = 'es_exam_index.html';

$i++;
$modversion['templates'][$i]['file'] = 'es_exam_show.html';
$modversion['templates'][$i]['description'] = 'es_exam_show.html';

$i++;
$modversion['templates'][$i]['file'] = 'es_exam_adm_main.html';
$modversion['templates'][$i]['description'] = 'es_exam_adm_main.html';

$i++;
$modversion['templates'][$i]['file'] = 'es_exam_adm_add.html';
$modversion['templates'][$i]['description'] = 'es_exam_adm_add.html';

$i++;
$modversion['templates'][$i]['file'] = 'es_exam_adm_score.html';
$modversion['templates'][$i]['description'] = 'es_exam_adm_score.html';

$i++;
$modversion['templates'][$i]['file'] = 'es_exam_empt.html';
$modversion['templates'][$i]['description'] = 'es_exam_empt.html';

/*
//---區塊設定---//
$modversion['blocks'][1]['file'] = "tad_new_assignment.php";
$modversion['blocks'][1]['name'] = _MI_ESEXAM_BNAME1;
$modversion['blocks'][1]['description'] = _MI_ESEXAM_BDESC1;
$modversion['blocks'][1]['show_func'] = "tad_new_assignment";
$modversion['blocks'][1]['template'] = "tad_new_assignment.html";
*/


$i=1 ;
//偏好設定
$modversion['config'][$i]['name'] = 'ESEXAM_BASE';					//起跳分數
$modversion['config'][$i]['title']   = '_MI_ESEXAM_CONFIG_T1';
$modversion['config'][$i]['description'] = '_MI_ESEXAM_CONFIG_D1';
$modversion['config'][$i]['formtype']    = 'text';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default'] = 70 ;			

$i++;
$modversion['config'][$i]['name'] = 'ESEXAM_LOST';					//未交作品給分
$modversion['config'][$i]['title']   = '_MI_ESEXAM_CONFIG_T2';
$modversion['config'][$i]['description'] = '_MI_ESEXAM_CONFIG_D2';
$modversion['config'][$i]['formtype']    = 'text';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default'] = 60 ;		
?>
