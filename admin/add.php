<?php
/*-----------引入檔案區--------------*/

$xoopsOption['template_main'] = "es_exam_adm_add.tpl";
include_once "header.php";
include_once "../function.php";
/*-----------function區--------------*/
//tad_assignment編輯表單
function tad_assignment_form($assn=""){
  global $xoopsDB,$xoopsTpl;

  //抓取預設值
  if(!empty($assn)){
    $DBV=get_tad_assignment($assn);
  }else{
    $DBV=array();
  }

  //預設值設定

  $assn=(!isset($DBV['assn']))?"":$DBV['assn'];
  $title=(!isset($DBV['title']))?"":$DBV['title'];
  $passwd=(!isset($DBV['passwd']))?"":$DBV['passwd'];
  $note=(!isset($DBV['note']))?"":$DBV['note'];
  $uid=(!isset($DBV['uid']))?"":$DBV['uid'];
  $open_show=(!isset($DBV['open_show']))?"1":$DBV['open_show'];
  $upload_mode=(!isset($DBV['upload_mode']))?"1":$DBV['upload_mode'];
  $gview_mode=(!isset($DBV['gview_mode']))?"1":$DBV['gview_mode'];
  $no_file=(!isset($DBV['no_file']))?"":$DBV['no_file'];
  $upload_url=(!isset($DBV['upload_url']))?"":$DBV['upload_url'];
  $ext_file=(!isset($DBV['ext_file']))?"":$DBV['ext_file'];
  $class_id=(!isset($DBV['class_id']))?"":$DBV['class_id'];
  $class_list= get_class_list() ;

  $op=(empty($assn))?"insert_tad_assignment":"update_tad_assignment";


      //取得中文班名
  $class_list_c = es_class_name_list_c('long')  ;

  $xoopsTpl->assign('class_list_c',$class_list_c);
  $xoopsTpl->assign('assn',$assn);
  $xoopsTpl->assign('title',$title);
  $xoopsTpl->assign('note',$note);
  $xoopsTpl->assign('passwd',$passwd);
  $xoopsTpl->assign('ext_file',$ext_file);
  $xoopsTpl->assign('upload_mode',$upload_mode);
  $xoopsTpl->assign('gview_mode',$gview_mode);
  $xoopsTpl->assign('no_file',$no_file);
  $xoopsTpl->assign('upload_url',$upload_url);

  $xoopsTpl->assign('open_show',$open_show);
  $xoopsTpl->assign('class_list',$class_list);
  $xoopsTpl->assign('class_id',$class_id);
  $xoopsTpl->assign('op',$op);

}

//新增資料到tad_assignment中
function insert_tad_assignment(){
  global $xoopsDB,$xoopsUser;
  $uid=$xoopsUser->getVar('uid');

    //資料檢查
  $myts =& MyTextSanitizer::getInstance();
  $title = $myts->htmlspecialchars($myts->addSlashes($_POST['title'] )   );
  $passwd = $myts->htmlspecialchars($myts->addSlashes($_POST['passwd'] )   );
  $note = $myts->htmlspecialchars($myts->addSlashes($_POST['note'] )   );
  $ext_file = $myts->htmlspecialchars($myts->addSlashes($_POST['ext_file'] )   );
  $_POST['open_show'] = intval($_POST['open_show']) ;
  $_POST['upload_mode'] = intval($_POST['upload_mode']) ;
  $_POST['gview_mode'] = intval($_POST['gview_mode']) ;
  $_POST['no_file'] = intval($_POST['no_file']) ;
  $_POST['upload_url'] = intval($_POST['upload_url']) ;

  foreach ($_POST['class_id'] as $class_id =>$class ) {
  	$sql = "insert into ".$xoopsDB->prefix("exam")." (`title`,class_id , `passwd`, `note`,`uid`,`open_show` ,upload_mode , ext_file ,create_date ,gview_mode  ,no_file ,upload_url )
   		values('$title',  '$class'  ,'$passwd','$note','{$uid}','{$_POST['open_show']}' ,'{$_POST['upload_mode']}'  ,'$ext_file' ,now()  ,'{$_POST['gview_mode']}'  ,'{$_POST['no_file']}' ,'{$_POST['upload_url']}' )";
   	//echo $sql .'<br />';
  	$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, $xoopsDB->error());
  }

  //取得最後新增資料的流水編號
  $assn=$xoopsDB->getInsertId();
  return $assn;
}



//更新tad_assignment某一筆資料
function update_tad_assignment($assn=""){
  global $xoopsDB,$xoopsUser;
  $uid=$xoopsUser->getVar('uid');

    //資料檢查
  $myts =& MyTextSanitizer::getInstance();
  $title = $myts->htmlspecialchars($myts->addSlashes($_POST['title'] )   );
  $passwd = $myts->htmlspecialchars($myts->addSlashes($_POST['passwd'] )   );
  $note = $myts->htmlspecialchars($myts->addSlashes($_POST['note'] )   );
  $ext_file = $myts->htmlspecialchars($myts->addSlashes($_POST['ext_file'] )   );
  //echo $_POST['open_show']  ;
  $_POST['open_show'] = intval($_POST['open_show']) ;
  $_POST['upload_mode'] = intval($_POST['upload_mode']) ;
  $_POST['gview_mode'] = intval($_POST['gview_mode']) ;
  $_POST['no_file'] = intval($_POST['no_file']) ;
  $_POST['upload_url'] = intval($_POST['upload_url']) ;

  $sql = "update ".$xoopsDB->prefix("exam")." set  `title` = '$title', `passwd` = '$passwd',  `note` = '$note',  `open_show` = '{$_POST['open_show']}'  , upload_mode='{$_POST['upload_mode']}'  , ext_file= '$ext_file'   ,gview_mode='{$_POST['gview_mode']}'  ,no_file='{$_POST['no_file']}' ,upload_url='{$_POST['upload_url']}'  where assn='$assn'     " ;

  $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, $xoopsDB->error());
  return $assn;
}

/*-----------執行動作判斷區----------*/
$op = (!isset($_REQUEST['op']))? "":$_REQUEST['op'];
$assn = (!isset($_REQUEST['assn']))? "":intval($_REQUEST['assn']);

switch($op){

  //新增資料
  case "insert_tad_assignment":
  insert_tad_assignment();
  header("location: index.php");
  break;

  //輸入表格
  case "tad_assignment_form";
  tad_assignment_form($assn);
  break;

  //刪除資料
  case "delete_tad_assignment";
  delete_tad_assignment($assn);
  header("location: index.php");
  break;


  //更新資料
  case "update_tad_assignment";
  update_tad_assignment($assn);
  header("location: index.php");
  break;


  //預設動作
  default:
  tad_assignment_form($assn);
  break;

}

/*-----------秀出結果區--------------*/
include_once 'footer.php';
?>
