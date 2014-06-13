<?php
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "es_exam_adm_score.html";
include_once "header.php";
include_once "../function.php";
/*-----------function區--------------*/


  

/*-----------執行動作判斷區----------*/
	//列出教師指定各項作業，作為選單
	if   ( in_array(1,$xoopsUser->groups())  )  
		$exam_list=get_exam_list() ;
	else 
		$exam_list=get_exam_list('teacher') ; 
  	$xoopsTpl->assign('exam_list' , $exam_list);
  	
if ($_GET['assn'])  {
	
	//些項作業的資料
	$data['exam']=  get_tad_assignment($_GET['assn']) ;
	
 	//檢查有無權限
	$my_uid = $xoopsUser->uid() ;
  	if  ( (! in_array(1,$xoopsUser->groups())  ) and ($my_uid <> $data['exam']['uid']) ) 
 		redirect_header("main.php",3, "非作業管理人，無法打成績！");
 	
 	//刪除檔案	
	if ( $_GET['op'])
		delete_tad_assignment_file($_GET['asfsn']);	
	
	//取得作業
	$data['stud']=  list_exam_file($_GET['assn'] ) ;
	
 

	//基本分
	$base_score= $xoopsModuleConfig['ESEXAM_BASE'] ;
	$bar_max=100- $base_score ;
	
	$xoopsTpl->assign('data' , $data);
	
	$xoopsTpl->assign('base_score' , $base_score);
	$xoopsTpl->assign('bar_max' , $bar_max);
 
}	

/*-----------秀出結果區--------------*/
include_once 'footer.php';
?>
