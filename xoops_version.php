<?php
$modversion = array();

//---�Ҳհ򥻸�T---//
$modversion['name'] = _MI_ESEXAM_NAME;
$modversion['version'] = 0.2;
$modversion['description'] = _MI_ESEXAM_DESC;
$modversion['author'] = _MI_ESEXAM_AUTHOR;
$modversion['credits'] = _MI_ESEXAM_CREDITS;
$modversion['help'] = 'page=help';
$modversion['license'] = 'GNU GPL 2.0';
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['image'] = "images/logo_{$xoopsConfig['language']}.png";
$modversion['dirname'] = basename(dirname(__FILE__));

//---�Ҳժ��A��T---//
$modversion['release_date'] = '2014/7/01';
$modversion['module_website_url'] = 'http://tad0616.net/';
$modversion['module_website_name'] = _MI_TAD_WEB;
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = 'http://tad0616.net/';
$modversion['author_website_name'] = _MI_TAD_WEB;
$modversion['min_php']=5.2;
$modversion['min_xoops']='2.5';
$modversion['min_tadtools']='2.02';
/*
//---paypal��T---//
$modversion ['paypal'] = array();
$modversion ['paypal']['business'] = 'prolin99@gmail.com';
$modversion ['paypal']['item_name'] = 'Donation : ' . _MI_TAD_WEB;
$modversion ['paypal']['amount'] = 0;
$modversion ['paypal']['currency_code'] = 'USD';
*/

//---��ƪ�[�c---//
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][1] = "exam";
$modversion['tables'][2] = "exam_files";
//$modversion['tables'][3] = "es_exam_types";

//---�Ұʫ�x�޲z�ɭ����---//
$modversion['system_menu'] = 1;

//---�w�˳]�w---//
$modversion['onInstall'] = "include/onInstall.php";
$modversion['onUpdate'] = "include/onUpdate.php";
$modversion['onUninstall'] = "include/onUninstall.php";


//---�޲z�����]�w---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

//---�ϥΪ̥D���]�w---//
$modversion['hasMain'] = 1;
$modversion['sub'][2]['name'] =_MI_ESEXAM_SMNAME2;
$modversion['sub'][2]['url'] = "show.php";


//---�˪O�]�w---//
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
$modversion['templates'][$i]['file'] = 'es_exam_adm_add_type.html';
$modversion['templates'][$i]['description'] = 'es_exam_adm_add_type.html';

/*
//---�϶��]�w---//
$modversion['blocks'][1]['file'] = "tad_new_assignment.php";
$modversion['blocks'][1]['name'] = _MI_ESEXAM_BNAME1;
$modversion['blocks'][1]['description'] = _MI_ESEXAM_BDESC1;
$modversion['blocks'][1]['show_func'] = "tad_new_assignment";
$modversion['blocks'][1]['template'] = "tad_new_assignment.html";
*/
?>
