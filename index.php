<?php
/*-----------引入檔案區--------------*/
include "header.php";
$xoopsOption['template_main'] = "es_exam_index.html";
include_once XOOPS_ROOT_PATH."/header.php";
/*-----------function區--------------*/

//列出所有tad_assignment資料
function list_tad_assignment_menu(){
  global $xoopsDB,$xoopsModule,$xoopsTpl  ;
  $now=xoops_getUserTimestamp(time());
  /*
  //只出現這學期的作業 0201  or 08/01 
  if  (date("m")>=2 and date("m")<8) 
  	 $beg_date = date( "Y-m-d", mktime (0,0,0,2 ,1, date("Y")) );
  elseif  	  (date("m")<2) 
  	 $beg_date = date( "Y-m-d", mktime (0,0,0,8 ,1, date("Y")-1) );
  else 
  	 $beg_date = date( "Y-m-d", mktime (0,0,0,8 ,1, date("Y")) );
  
  $sql = "select assn,title,uid , class_id  from ".$xoopsDB->prefix("exam")." where  upload_mode ='1' and  create_date>=$beg_date  order by class_id ,  assn desc  ";
 
  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  $i=0;
  $data="";
  while(list($assn,$title,$uid,$class_id)=$xoopsDB->fetchRow($result)){
    $uid_name=XoopsUser::getUnameFromId($uid,1);
    if(empty($uid_name))$uid_name=XoopsUser::getUnameFromId($uid,0);
    $data[$i]['assn']=$assn;
    $data[$i]['title']=$title;
    $data[$i]['uid_name']=$uid_name;
     $data[$i]['class_id']=$class_id;

    $i++;
  }
 */
 
  $data = get_exam_list('upload') ;
  
  $xoopsTpl->assign('all',$data);
  $xoopsTpl->assign('assn', intval($_GET['assn']));
  $xoopsTpl->assign('now_op','list_tad_assignment_menu');
}




//tad_assignment_file編輯表單------------------------------------------------------------
function tad_assignment_file_form($assn=""){
  global $xoopsDB,$xoopsTpl;
  
  $assignment=get_tad_assignment($_POST['assn']);
  if($_POST['passwd']!=$assignment['passwd']){
    redirect_header($_SERVER['PHP_SELF'] ."?assn={$_POST['assn']}",3, _TAD_ASSIGNMENT_WRONG_PASSWD);
    exit;
  }
    //不可以上傳
  if( $assignment['upload_mode'] ==0 ){
    redirect_header($_SERVER['PHP_SELF'],3, "這個作業已關畢了，無法上傳！");
    exit;
  }
  
  $DBV=get_tad_assignment($assn);
  foreach($DBV as $k=>$v){
    $$k=$v;
    $xoopsTpl->assign($k,$v);
  }

  //取得學生資料
  $stud_name=   get_stud_name($class_id , $_POST['sit_id']) ;
  if( ! $stud_name){
    redirect_header($_SERVER['PHP_SELF']."?assn={$_POST['assn']}" ,3, "找不到合適的學生，請重新輸入座號" );
    exit;
  }
  $j_ext_file  = str_replace(',', '|', $ext_file);
 
  
  $xoopsTpl->assign('note',nl2br($note));
  $xoopsTpl->assign('sit_id',$_POST['sit_id']);
  $xoopsTpl->assign('stud_name',$stud_name );
  $xoopsTpl->assign('j_ext_file',$j_ext_file );
  $xoopsTpl->assign('now_op','tad_assignment_file_form');
}

//新增資料到tad_assignment_file中-----------------------------------------------------------------------------------
function insert_tad_assignment_file(){
  global $xoopsDB;
  $assignment=get_tad_assignment($_POST['assn']);
  if($_POST['passwd']!=$assignment['passwd']){
    redirect_header($_SERVER['PHP_SELF'],3, _TAD_ASSIGNMENT_WRONG_PASSWD);
    exit;
  }
  

  
  $now=date("Y-m-d H:i:s");
  //刪除舊檔案
  $sql = "SELECT * FROM " .$xoopsDB->prefix("exam_files")." WHERE `assn` ='{$_POST['assn']}' and  class_id='{$_POST['class_id']}' and sit_id= '{$_POST['sit_id']}'  " ;
 
  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  while($row=$xoopsDB->fetchArray($result)){
 			$old_asfsn = $row['asfsn'] ;
	}
 
  if ( $old_asfsn ) {
	delete_tad_assignment_file($old_asfsn) ;
  }   
 
 
  
  //新增
  $sql = "insert into ".$xoopsDB->prefix("exam_files")." (`assn` ,   `show_name` , `desc` , class_id , sit_id  ,`author` ,  `up_time`) 
   		values('{$_POST['assn']}', '{$_POST['show_name']}','{$_POST['desc']}','{$_POST['class_id']}', '{$_POST['sit_id']}', '{$_POST['author']}',  '$now')";
  $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  //取得最後新增資料的流水編號
  $asfsn=$xoopsDB->getInsertId();

  upload_file($asfsn,$_POST['assn']);

  return $_POST['assn'];
}

//上傳檔案
function upload_file($asfsn="",$assn=""){
  global $xoopsDB;
  include_once XOOPS_ROOT_PATH."/modules/tadtools/upload/class.upload.php";
  set_time_limit(0);
  ini_set('memory_limit', '150M');
  $flv_handle = new upload($_FILES['file'],"zh_TW");
  if ($flv_handle->uploaded) {
      //$name=substr($_FILES['file']['name'],0,-4);
      $flv_handle->file_safe_name = false;
      $flv_handle->mime_check = false;

      $flv_handle->auto_create_dir = true;
      $flv_handle->file_new_name_body   = "{$asfsn}";
      $flv_handle->process(_TAD_ASSIGNMENT_UPLOAD_DIR."{$assn}/");
      $now=date("Y-m-d H:i:s");
      if ($flv_handle->processed) {
          $flv_handle->clean();
          $sql = "update ".$xoopsDB->prefix("exam_files")." set file_name='{$_FILES['file']['name']}',file_size='{$_FILES['file']['size']}' ,file_type='{$_FILES['file']['type']}',`up_time`='$now'  where asfsn='$asfsn'";
          $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
      } else {
          $sql = "delete from ".$xoopsDB->prefix("exam_files")." where asfsn='{$asfsn}'";
          $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
          redirect_header($_SERVER['PHP_SELF'],3, "Error:".$flv_handle->error);
      }
   }
}



/*-----------執行動作判斷區----------*/
$_REQUEST['op']=(empty($_REQUEST['op']))?"":$_REQUEST['op'];
$assn = (!isset($_REQUEST['assn']))? "":intval($_REQUEST['assn']);

switch($_REQUEST['op']){

  //登入作業
  case "login_es_exam":

  tad_assignment_file_form($assn);
  break;  
  //新增資料
  case "insert_tad_assignment_file":
  $assn=insert_tad_assignment_file();
  header("location: show.php?assn=$assn");
  break;

  //預設動作
  default:
  list_tad_assignment_menu();
 
 
  break;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign( "toolbar" , toolbar_bootstrap($interface_menu)) ;
$xoopsTpl->assign( "bootstrap" , get_bootstrap()) ;
$xoopsTpl->assign( "jquery" , get_jquery(true)) ;
$xoopsTpl->assign( "isAdmin" , $isAdmin) ;

include_once XOOPS_ROOT_PATH.'/footer.php';
?>
