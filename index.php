<?php
/*-----------�ޤJ�ɮװ�--------------*/
include "header.php";
$xoopsOption['template_main'] = "es_exam_index.html";
include_once XOOPS_ROOT_PATH."/header.php";
/*-----------function��--------------*/

//�C�X�Ҧ�tad_assignment���
function list_tad_assignment_menu(){
  global $xoopsDB,$xoopsModule,$xoopsTpl  ;
  $now=xoops_getUserTimestamp(time());
  /*
  //�u�X�{�o�Ǵ����@�~ 0201  or 08/01 
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




//tad_assignment_file�s����------------------------------------------------------------
function tad_assignment_file_form($assn=""){
  global $xoopsDB,$xoopsTpl;
  
  $assignment=get_tad_assignment($_POST['assn']);
  if($_POST['passwd']!=$assignment['passwd']){
    redirect_header($_SERVER['PHP_SELF'] ."?assn={$_POST['assn']}",3, _TAD_ASSIGNMENT_WRONG_PASSWD);
    exit;
  }
    //���i�H�W��
  if( $assignment['upload_mode'] ==0 ){
    redirect_header($_SERVER['PHP_SELF'],3, "�o�ӧ@�~�w�����F�A�L�k�W�ǡI");
    exit;
  }
  
  $DBV=get_tad_assignment($assn);
  foreach($DBV as $k=>$v){
    $$k=$v;
    $xoopsTpl->assign($k,$v);
  }

  //���o�ǥ͸��
  $stud_name=   get_stud_name($class_id , $_POST['sit_id']) ;
  if( ! $stud_name){
    redirect_header($_SERVER['PHP_SELF']."?assn={$_POST['assn']}" ,3, "�䤣��X�A���ǥ͡A�Э��s��J�y��" );
    exit;
  }
  $j_ext_file  = str_replace(',', '|', $ext_file);
 
  
  $xoopsTpl->assign('note',nl2br($note));
  $xoopsTpl->assign('sit_id',$_POST['sit_id']);
  $xoopsTpl->assign('stud_name',$stud_name );
  $xoopsTpl->assign('j_ext_file',$j_ext_file );
  $xoopsTpl->assign('now_op','tad_assignment_file_form');
}

//�s�W��ƨ�tad_assignment_file��-----------------------------------------------------------------------------------
function insert_tad_assignment_file(){
  global $xoopsDB;
  $assignment=get_tad_assignment($_POST['assn']);
  if($_POST['passwd']!=$assignment['passwd']){
    redirect_header($_SERVER['PHP_SELF'],3, _TAD_ASSIGNMENT_WRONG_PASSWD);
    exit;
  }
  

  
  $now=date("Y-m-d H:i:s");
  //�R�����ɮ�
  $sql = "SELECT * FROM " .$xoopsDB->prefix("exam_files")." WHERE `assn` ='{$_POST['assn']}' and  class_id='{$_POST['class_id']}' and sit_id= '{$_POST['sit_id']}'  " ;
 
  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  while($row=$xoopsDB->fetchArray($result)){
 			$old_asfsn = $row['asfsn'] ;
	}
 
  if ( $old_asfsn ) {
	delete_tad_assignment_file($old_asfsn) ;
  }   
 
 
  
  //�s�W
  $sql = "insert into ".$xoopsDB->prefix("exam_files")." (`assn` ,   `show_name` , `desc` , class_id , sit_id  ,`author` ,  `up_time`) 
   		values('{$_POST['assn']}', '{$_POST['show_name']}','{$_POST['desc']}','{$_POST['class_id']}', '{$_POST['sit_id']}', '{$_POST['author']}',  '$now')";
  $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  //���o�̫�s�W��ƪ��y���s��
  $asfsn=$xoopsDB->getInsertId();

  upload_file($asfsn,$_POST['assn']);

  return $_POST['assn'];
}

//�W���ɮ�
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



/*-----------����ʧ@�P�_��----------*/
$_REQUEST['op']=(empty($_REQUEST['op']))?"":$_REQUEST['op'];
$assn = (!isset($_REQUEST['assn']))? "":intval($_REQUEST['assn']);

switch($_REQUEST['op']){

  //�n�J�@�~
  case "login_es_exam":

  tad_assignment_file_form($assn);
  break;  
  //�s�W���
  case "insert_tad_assignment_file":
  $assn=insert_tad_assignment_file();
  header("location: show.php?assn=$assn");
  break;

  //�w�]�ʧ@
  default:
  list_tad_assignment_menu();
 
 
  break;
}

/*-----------�q�X���G��--------------*/
$xoopsTpl->assign( "toolbar" , toolbar_bootstrap($interface_menu)) ;
$xoopsTpl->assign( "bootstrap" , get_bootstrap()) ;
$xoopsTpl->assign( "jquery" , get_jquery(true)) ;
$xoopsTpl->assign( "isAdmin" , $isAdmin) ;

include_once XOOPS_ROOT_PATH.'/footer.php';
?>
