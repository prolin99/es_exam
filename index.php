<?php
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
include 'header.php';
$xoopsOption['template_main'] = 'es_exam_index.tpl';
include_once XOOPS_ROOT_PATH.'/header.php';
/*-----------function區--------------*/

//列出所有tad_assignment資料
function list_tad_assignment_menu()
{
    global $xoopsDB,$xoopsModule,$xoopsTpl;
    $now = xoops_getUserTimestamp(time());

  //取得中文班名
  $class_list_c = es_class_name_list_c('long');

 //出現可以上傳的作業
  $data = get_exam_list('upload');

    $xoopsTpl->assign('class_list_c', $class_list_c);
    $xoopsTpl->assign('all', $data);
    $xoopsTpl->assign('assn', intval($_GET['assn']));
    $xoopsTpl->assign('now_op', 'list_tad_assignment_menu');
}

//進入上傳畫面   -----------------------------------------------------------
function tad_assignment_file_form($assn = '')
{
    global $xoopsDB,$xoopsTpl;
    $_POST['assn'] = intval($_POST['assn']);

    $assignment = get_tad_assignment(intval($_POST['assn']));
    if ($_POST['passwd'] != $assignment['passwd']) {
        redirect_header($_SERVER['PHP_SELF']."?assn={$_POST['assn']}", 3, _TAD_ASSIGNMENT_WRONG_PASSWD);
        exit;
    }
    //不可以上傳
    if ($assignment['upload_mode'] == 0) {
      redirect_header($_SERVER['PHP_SELF'], 3, '這個作業不開放上傳！');
      exit;
    }

    $DBV = get_tad_assignment($assn);
    foreach ($DBV as $k => $v) {
        $$k = $v;
        $xoopsTpl->assign($k, $v);
    }

    //取得學生資料
    $stud_data = get_stud_name($class_id, intval($_POST['sit_id']));
    if (!$stud_data) {
        redirect_header($_SERVER['PHP_SELF']."?assn={$_POST['assn']}", 3, '找不到合適的學生，請重新輸入座號');
        exit;
    }

    //取得中文班名
    $class_list_c = es_class_name_list_c('long');



    if ($ext_file) {
        //可上傳的副檔
        $j_ext_file = str_replace(',', '|', $ext_file);
        $accept_filestr = str_replace(',', ',.', $ext_file);
        $accept_filestr = " accept='.{$accept_filestr}' ";
    }

    //取得上次作業的說明文字
    $old_file = get_stud_old_exam( $assn , $class_id ,intval($_POST['sit_id']) ) ;

    $xoopsTpl->assign('class_list_c', $class_list_c);
    $xoopsTpl->assign('note', nl2br($note));
    $xoopsTpl->assign('sit_id', intval($_POST['sit_id'])  );
    $xoopsTpl->assign('stud_data', $stud_data);
    $xoopsTpl->assign('desc', $old_file['memo']);
    $xoopsTpl->assign('show_name', $old_file['show_name']);     //網址

    $xoopsTpl->assign('team_sitid_list', $old_file['team_sitid_list']);     //組員座號

    $xoopsTpl->assign('j_ext_file', $j_ext_file);
    $xoopsTpl->assign('accept_filestr', $accept_filestr);

    $xoopsTpl->assign('now_op', 'tad_assignment_file_form');


}

//上傳動作，新增資料到tad_assignment_file中-----------------------------------------------------------------------------------
function insert_tad_assignment_file()
{
    global $xoopsDB ,$xoopsModuleConfig ;

    //密碼再次確認
    $assignment = get_tad_assignment(intval($_POST['assn']));
    if ($_POST['passwd'] != $assignment['passwd']) {
        redirect_header($_SERVER['PHP_SELF'], 3, _TAD_ASSIGNMENT_WRONG_PASSWD);
        exit;
    }

    //資料檢查
    $_POST['assn'] = intval($_POST['assn']);
    $_POST['class_id'] = intval($_POST['class_id']);
    $_POST['sit_id'] = intval($_POST['sit_id']);
    $_POST['stud_id'] = $_POST['stud_id'];

    $now = date('Y-m-d H:i:s');

  //檢查學生先前上傳的檔案，並刪除舊檔案 ，再新增檔案
  /*
  $sql = 'SELECT * FROM '.$xoopsDB->prefix('exam_files')." WHERE `assn` ='{$_POST['assn']}' and  class_id='{$_POST['class_id']}' and sit_id= '{$_POST['sit_id']}'  ";

    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, $xoopsDB->error());
    while ($row = $xoopsDB->fetchArray($result)) {
        $old_asfsn = $row['asfsn'];
        $stud_id = $row['stud_id'];
    }
    */
    $old_file = get_stud_old_exam($_POST['assn'] ,$_POST['class_id'] ,$_POST['sit_id'] ) ;
    $no_real_del = $xoopsModuleConfig['ESEXAM_MULTI_FILES'] ;

    if ($old_file['old_asfsn']) {
        if ($no_real_del ){
            mark_old_tad_assignment_file($old_file['old_asfsn'], $old_file['stud_id']    );

        }else{
            //刪除舊檔
            delete_tad_assignment_file($old_file['old_asfsn'], $old_file['stud_id']   );

        }
    }

  //資料檢查
  $myts = &MyTextSanitizer::getInstance();
  $desc = $myts->htmlspecialchars($xoopsDB->escape($_POST['desc']));
  $author = $myts->htmlspecialchars($xoopsDB->escape($_POST['author']));
  $show_name = $myts->htmlspecialchars($xoopsDB->escape($_POST['show_name']));
  $team_sitid_list = $myts->htmlspecialchars($xoopsDB->escape($_POST['team_sitid_list']));
  #只留數字和空白
  $team_sitid_list = preg_replace('/[^0-9\s.]+/', '', $team_sitid_list);

  //取得 IP (可能ipv6 或 ipv4)
  if ($_SERVER['HTTP_X_FORWARDED_FOR']){
          $remoIP=$_SERVER['HTTP_X_FORWARDED_FOR'];
  }  else {
          $remoIP=$_SERVER['REMOTE_ADDR'];
  }

  //新增 commet 要先空值
  $sql = 'insert into '.$xoopsDB->prefix('exam_files')." (`assn` ,   `show_name` , `memo` , class_id , sit_id  ,`author` ,  stud_id ,  `up_time` ,`comment` , `up_ip` ,team_sitid_list )
   		values('{$_POST['assn']}', '$show_name','$desc','{$_POST['class_id']}', '{$_POST['sit_id']}', '$author',  '{$_POST['stud_id']}' ,  '$now' ,'' ,'$remoIP'  , '$team_sitid_list' )";

  $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, $xoopsDB->error());

  //取得最後新增資料的流水編號
  $asfsn = $xoopsDB->getInsertId();

  upload_file($asfsn, $_POST['assn']);
  return $_POST['assn'];
}

//上傳檔案
function upload_file($asfsn = '', $assn = '')
{
    global $xoopsDB;
    include_once XOOPS_ROOT_PATH.'/modules/tadtools/upload/class.upload.php';
    set_time_limit(0);
    ini_set('memory_limit', '150M');
    $flv_handle = new \Verot\upload\upload($_FILES['file'], 'zh_TW');



    if ($flv_handle->uploaded) {
        //$name=substr($_FILES['file']['name'],0,-4);
        $flv_handle->file_safe_name = false;
        $flv_handle->mime_check = false;

        $flv_handle->auto_create_dir = true;
        $flv_handle->file_new_name_body = "{$asfsn}";
        $flv_handle->process(_TAD_ASSIGNMENT_UPLOAD_DIR."{$assn}/");
        $now = date('Y-m-d H:i:s');
        if ($flv_handle->processed) {
            $flv_handle->clean();
            $sql = 'update '.$xoopsDB->prefix('exam_files')." set file_name='{$_FILES['file']['name']}',file_size='{$_FILES['file']['size']}' ,file_type='{$_FILES['file']['type']}',`up_time`='$now'  where asfsn='$asfsn'";

            $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, $xoopsDB->error());
        } else {
            $sql = 'delete from '.$xoopsDB->prefix('exam_files')." where asfsn='{$asfsn}'";
            $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, $xoopsDB->error());
            redirect_header($_SERVER['PHP_SELF'], 3, 'Error:'.$flv_handle->error);
        }
    }
}

/*-----------執行動作判斷區----------*/
$_REQUEST['op'] = (empty($_REQUEST['op'])) ? '' : strip_tags($_REQUEST['op']);
$assn = (!isset($_REQUEST['assn'])) ? '' : intval($_REQUEST['assn']);

switch ($_REQUEST['op']) {

  //登入作業
  case 'login_es_exam':
    tad_assignment_file_form($assn);
  break;

  //新增資料
  case 'insert_tad_assignment_file':
    $assn = insert_tad_assignment_file();
    header("location: show.php?assn=$assn");
  break;

  //預設動作
  default:
    list_tad_assignment_menu();

  break;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('toolbar', Utility::toolbar_bootstrap($interface_menu));
$xoopsTpl->assign('bootstrap', Utility::get_bootstrap());
$xoopsTpl->assign('jquery', Utility::get_jquery(true));
$xoopsTpl->assign('isAdmin', $isAdmin);

include_once XOOPS_ROOT_PATH.'/footer.php';
