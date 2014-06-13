<?php
//引入TadTools的函式庫
if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/tad_function.php")){
 redirect_header("http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50",3, _TAD_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH."/modules/tadtools/tad_function.php";

define("_TAD_ASSIGNMENT_UPLOAD_DIR",XOOPS_ROOT_PATH."/uploads/es_exam/");
define("_TAD_ASSIGNMENT_UPLOAD_URL",XOOPS_URL."/uploads/es_exam/");


function  get_exam_list($mode , $semester=1) {
	global $xoopsDB, $xoopsUser;
	if  ($semester) {
		//只出現這學期的作業 0201  or 08/01 
		if  (date("m")>=2 and date("m")<8) 
			$beg_date = date( "Y-m-d", mktime (0,0,0,2 ,1, date("Y")) );
		elseif  	  (date("m")<2) 
			$beg_date = date( "Y-m-d", mktime (0,0,0,8 ,1, date("Y")-1) );
		else 
			$beg_date = date( "Y-m-d", mktime (0,0,0,8 ,1, date("Y")) );
		$and_date_sql = "  and   create_date>=$beg_date	" ; 
	}		
  	if ($mode=='upload') {
		$sql_and = " and upload_mode ='1' " ;
  	}	
  	if ($mode=='show') {
		$sql_and = "  and open_show ='1'  " ;
  	}  	
  	
  	//教師，只列出自已開設的作業
  	if ($mode=='teacher') {
		$my_uid = $xoopsUser->uid() ;
		$sql_and = " and uid ='$my_uid'  " ;
  	}  	
  	
  $sql = "select assn,title,uid , class_id,open_show  from ".$xoopsDB->prefix("exam")." where 1    $sql_and     $and_date_sql   order by class_id ,  assn desc  ";
 //echo $sql ;
  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  $i=0;
  $data="";
  while(list($assn,$title,$uid,$class_id ,$open_show )=$xoopsDB->fetchRow($result)){
    $uid_name=XoopsUser::getUnameFromId($uid,1);
    if(empty($uid_name))$uid_name=XoopsUser::getUnameFromId($uid,0);
    $data[$i]['assn']=$assn;
    $data[$i]['title']=$title;
    $data[$i]['uid_name']=$uid_name;
     $data[$i]['class_id']=$class_id;
     $data[$i]['open_show']=$open_show;

    $i++;
  }
  return  $data  ;
}


//列出所有tad_assignment_file資料
function list_exam_file($assn=""  , $my_order=' `up_time` DESC '){
  global $xoopsDB,$xoopsModule,$isAdmin,$xoopsTpl ,$xoopsModuleConfig ;
  
  $base_score= $xoopsModuleConfig['ESEXAM_BASE'] ;

  //作業主題
  $DBV=get_tad_assignment($assn);
  foreach($DBV as $k=>$v){
    $$k=$v;
    $xoopsTpl->assign($k,$v);
  }

  //班級名單
  $sql =  "  SELECT  class_sit_num , name  FROM " . $xoopsDB->prefix("e_student") . "   where class_id='{$class_id}'  order by  class_sit_num  " ;
  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  while($row=$xoopsDB->fetchArray($result)){
	$class_students[$row['class_sit_num']]['name']=$row['name'] ;
  }	
  $xoopsTpl->assign('class_students',$class_students); 
  
  //個人作品
  $sql = "select * from ".$xoopsDB->prefix("exam_files")." where assn='{$assn}' order by $my_order  ";
  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

  $i=0;
  $data="";
  while($all=$xoopsDB->fetchArray($result)){

    foreach($all as $k=>$v){
	
      $$k=$v;
      $data[$i][$k]=$v;
    }

    $show_name=(empty($show_name))?$author._MD_TADASSIGN_UPLOAD_FILE:$show_name;
    $filepart=explode('.',$file_name);
    foreach($filepart as $ff){
      $sub_name=strtolower($ff);
    }

    $data[$i]['sub_name']=$sub_name;
    $data[$i]['show_name']=$show_name;
    
    //作品座號標記
    $class_students[$sit_id]['in']= 1 ;
 
    //成績 bar
    $data[$i]['score_bar']=$data[$i]['score']-$base_score ;
    if  ($data[$i]['score_bar']<0) $data[$i]['score_bar']=0 ;
    
    $i++ ;
 } 
     $xoopsTpl->assign('class_students',$class_students); 
    return $data ;
}
  
 
//以流水號取得某筆tad_assignment資料
function get_tad_assignment($assn=""){
  global $xoopsDB;
  if(empty($assn))return;
  $sql = "select * from ".$xoopsDB->prefix("exam")." where assn='$assn'";
  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  $data=$xoopsDB->fetchArray($result);
  return $data;
}


//轉換成時間戳記
function day2ts($day="",$sy="-"){
  if(empty($day))$day=date("Y-m-d H:i:s");
  $dt=explode(" ",$day);

  $d=explode($sy,$dt[0]);
  $t=explode(":",$dt[1]);

  $ts=mktime($t['0'],$t['1'],$t['2'],$d['1'],$d['2'],$d['0']);
  return $ts;
}

//刪除tad_assignment_file某筆資料資料
function delete_tad_assignment_file($asfsn=""){
  global $xoopsDB;

  $sql = "select * from ".$xoopsDB->prefix("exam_files")." where asfsn='{$asfsn}'";
  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  while($all=$xoopsDB->fetchArray($result)){
    foreach($all as $k=>$v){
      $$k=$v;
    }
  }

  $filepart=explode('.',$file_name);
  foreach($filepart as $ff){
    $sub_name=strtolower($ff);
  }

  unlink(_TAD_ASSIGNMENT_UPLOAD_DIR."{$assn}/{$asfsn}.{$sub_name}");

  $sql = "delete from ".$xoopsDB->prefix("exam_files")." where asfsn='$asfsn'";
  $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
}


/********************* 預設函數 *********************/

function get_class_list(  ) {
	//取得全校班級列表 
	global  $xoopsDB ;
 
		$sql =  "  SELECT  class_id  FROM " . $xoopsDB->prefix("e_student") . "   group by class_id   " ;
 
		$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
		while($row=$xoopsDB->fetchArray($result)){
 
			$data[$row['class_id']]=$row['class_id'] ;
	
		}		
	return $data ;		
	
}

function get_stud_name($class_id , $sit_id) {
	//取得學生姓名
	global  $xoopsDB ;
 
		$sql =  "  SELECT  name  FROM " . $xoopsDB->prefix("e_student") . "   where class_id='$class_id' and class_sit_num='$sit_id'  " ;
 
		$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
		while($row=$xoopsDB->fetchArray($result)){
			$data=$row['name'] ;
		}		
	return $data ;	
}

 


 