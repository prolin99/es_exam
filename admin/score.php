<?php
/*-----------引入檔案區--------------*/

$xoopsOption['template_main'] = "es_exam_adm_score.tpl";
include_once "header.php";
include_once "../function.php";
/*-----------function區--------------*/

//資料檢查
$_GET['assn'] = intval($_GET['assn']) ;


/*-----------執行動作判斷區----------*/
	//列出教師指定各項作業，作為選單

$exam_list=get_exam_list('teacher') ;
//取得中文班名
$class_list_c = es_class_name_list_c('long')  ;

$xoopsTpl->assign('class_list_c',$class_list_c);
$xoopsTpl->assign('exam_list' , $exam_list);

if ($_GET['assn'])  {

	//這項作業的資料
	$data['exam']=  get_tad_assignment($_GET['assn']) ;

	//檢查有無權限
	$my_uid = $xoopsUser->uid() ;
	if  ( (! in_array(1,$xoopsUser->groups())  ) and ($my_uid <> $data['exam']['uid']) )
		redirect_header("main.php",3, "非作業管理人，無法打成績！");

	//刪除檔案
	if ( $_GET['op']=='delete_tad_assignment_file')
		delete_tad_assignment_file($_GET['asfsn'] ,$_GET['stud_id']  );

	//填入空作業記錄，以提供成績輸入
	if ( $_GET['op']=='emp_job') {
		exam_set_empfile($_GET['assn'],$data['exam']['class_id']) ;
		redirect_header("score.php?assn=" .$_GET['assn'] ) ;
	}


	//取得作業
	if ($_GET['order']=='num_id')
		$data['stud']=  list_exam_file($_GET['assn'] ,' sit_id ' )  ;
	else
		$data['stud']=  list_exam_file($_GET['assn']  );
	//已交作業數
	$data['count_exams'] = count($data['stud']??[]) ;

	//判別是否要以框架出現，評分用  或迫以 google view
	if  ($data['exam']['ext_file']   ) {
		$data['ifram_show'] = preg_match('/(jpg|jpeg|swf|bmp|png|gif|sb|sb2|svg)/i'  ,$data['exam']['ext_file'] ) ;
	}else {
		$data['ifram_show']  = 0 ;
	}
	//強迫使用 google 來查看
	if ($data['exam']['gview_mode'] )
		$data['ifram_show']  = 1 ;



	//基本分，拉bar 值
	$base_score= $xoopsModuleConfig['ESEXAM_BASE'] ;
	$bar_max=100- $base_score ;

	//未交作業，給的分數
 	$score_lost= $xoopsModuleConfig['ESEXAM_LOST'] ;

	$xoopsTpl->assign('data' , $data);

	$xoopsTpl->assign('base_score' , $base_score);
	$xoopsTpl->assign('bar_max' , $bar_max);
	$xoopsTpl->assign('score_lost' , $score_lost);
	$xoopsTpl->assign('gview_mode' , $data['exam']['gview_mode']);


}

/*-----------秀出結果區--------------*/
include_once 'footer.php';
?>
