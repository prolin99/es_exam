<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-05-01
// $Id:$
// ------------------------------------------------------------------------- //
/*-----------引入檔案區--------------*/
include_once "header.php";
include_once "../function.php";

include_once "../../tadtools/PHPExcel.php";
require_once '../../tadtools/PHPExcel/IOFactory.php';    
/*-----------function區--------------*/


//取得一項作業的成績
function get_score($assn)  {
	global $xoopsDB,$xoopsModule,$isAdmin,$xoopsTpl ,$xoopsModuleConfig ;	
  	//個人作品
  	$sql = "select stud_id , score  from ".$xoopsDB->prefix("exam_files")." where assn='{$assn}' order by sit_id  ";
 
  	$result = $xoopsDB->query($sql) or die($sql."<br>". mysql_error()); 
  	while($row=$xoopsDB->fetchArray($result)){
		if  ($row['score']==0 )
			$row['score']='未評' ;
		$data[$row['stud_id']]=$row['score'] ;
   	}	
   	return $data ;
	
}	

function get_class_stud_list( $class_id ) {
	//取得該班的學生名冊 
	global  $xoopsDB ;
 
		$sql =  "  SELECT  class_id ,stud_id , class_sit_num , name  FROM " . $xoopsDB->prefix("e_student") . "   where class_id='$class_id'   order by  class_sit_num " ;
		$result = $xoopsDB->query($sql) or die($sql."<br>". mysql_error()); 
		while($row=$xoopsDB->fetchArray($result)){
 			$data[]=$row ;
		}		
	return $data ;		
	
}

/*-----------執行動作判斷區----------*/

if  ($_GET['op']) {
	//未交作業，給的分數
 	$score_lost= $xoopsModuleConfig['ESEXAM_LOST'] ;
 	
	//取得所屬作業 排序 班級-作業
 	$exam_list= get_exam_list('teacher' ,  'class_id ,  assn' ) ;
 	$class_id = intval($_GET['class'] );
 	//取得各班的多項成績
 	$ei = 0 ;
 	foreach ($exam_list as  $k=>$exam ) {

		if  ($_GET['op'] == 'all' )  {
			if ($now_class <>  $exam['class_id'] ) {
				//換班，分數序歸 0 
				$now_class =$exam['class_id'] ;
				$ei = 0 ;
				$stud_data[$now_class] =  get_class_stud_list($now_class) ;
			}		
			//取得成績
			$score_data[$now_class][$ei] = get_score($exam['assn'])  ;
			$ei ++ ;
		}else {	
			if ($exam['class_id'] ==$class_id ) {
				//單一班級
				//取得成績
				$score_data[$class_id][$ei] = get_score($exam['assn'])  ;
				if ( !$stud_data[$class_id]) 
					$stud_data[$class_id] =  get_class_stud_list($class_id) ;
			}
			$ei ++ ;
		}
		
 	}	

 

 	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);  //設定預設顯示的工作表
	$objActSheet = $objPHPExcel->getActiveSheet(); //指定預設工作表為 $objActSheet
	$objActSheet->setTitle("學期成績");  //設定標題	
  	//設定框線
	$objBorder=$objActSheet->getDefaultStyle()->getBorders();
	$objBorder->getBottom()
          	->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
          	->getColor()->setRGB('000000'); 
	$objActSheet->getDefaultRowDimension()->setRowHeight(15);

	
	$row= 1 ;
	/*
       //標題行
      	$objPHPExcel->setActiveSheetIndex(0) 
            ->setCellValue('A' . $row, '班級')
            ->setCellValue('B' . $row, '座號')
            ->setCellValue('C' . $row, '姓名') ;
 
	//成績欄
      	$col ='C' ;
      	for ($i =1 ; $i <=10;$i++) {
		$col++ ;
		$col_str =$col .$row ;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_str ,$i) ;
      	}	
 */
        //取得中文班名
        $class_list_c = es_class_name_list_c('long')  ;

        //資料區
        foreach ( $stud_data  as $class_id => $class_list )  {
		
		if ($row<>1) $row += 4 ;		//多班級時，間隔
		//標題行
		$objPHPExcel->setActiveSheetIndex(0) 
		->setCellValue('A' . $row, '班級')
		->setCellValue('B' . $row, '座號')
		->setCellValue('C' . $row, '姓名') ;
	
		//成績欄
		$col ='C' ;
		$i=1 ;
		foreach ($score_data[$class_id]  as $ei=>$score_one) {
		//for ($i =1 ; $i <=10;$i++) {
			$i_str='作業'.$i ;
			$col++ ;
			$col_str =$col .$row ;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_str ,$i_str) ;
			$i++ ;
		}
		foreach ( $class_list  as $order => $stud )  {
			$row++ ;
			$stud_order++ ;
			
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$row,$class_list_c[$stud['class_id']])
				->setCellValue('B'.$row , $stud['class_sit_num'])
				->setCellValue('C'.$row ,$stud['name']) ;
			$stud_id= $stud['stud_id']  ;
			//成績
			$col ='C' ;
			
			foreach ($score_data[$class_id]  as $ei=>$score_one) {
	 
					$col++ ;
					$col_str =$col .$row ;
					
					//成績，未交給設定分	
					$my_data=$score_one[$stud_id] ;
					if ($my_data =='' )  {
						$my_data=$score_lost ;
						$objPHPExcel->getActiveSheet(0)->getStyle($col_str)->getFont()->getColor()->setARGB('FF808080');
					}	
 
					   $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_str , $my_data) ;
					   
  
			}	//end foreach --成績
		}	//end foreach --班級
		
 
  
	} 	

 	ob_clean() ;
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename=score'.date("mdHi").'.xls' );
	header('Cache-Control: max-age=0');

	//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;		
 
}	
?>