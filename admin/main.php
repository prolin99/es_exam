<?php
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "es_exam_adm_main.tpl";
include_once "header.php";
include_once "../function.php";
/*-----------function區--------------*/


//列出所有tad_assignment資料
function list_tad_assignment($show_function=1 ,$semester =1  ){

	global $xoopsDB,$xoopsModule,$xoopsTpl , $xoopsUser ;

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

	//只列出自已建立的
	$my_uid = $xoopsUser->uid() ;
	if (! in_array(1,$xoopsUser->groups())   )
 		$and_my_sql = "  and   uid='$my_uid' 	" ;


	$sql = "select * from ".$xoopsDB->prefix("exam")." where 1  $and_my_sql  $and_date_sql  order by   create_date desc , class_id ASC ";

	//PageBar(資料數, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
	$result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
	$total  = $xoopsDB->getRowsNum($result);

	$PageBar = Utility::getPageBar($sql, 20, 10);
	$bar     = $PageBar['bar'];
    $sql     = $PageBar['sql'];
    $total   = $PageBar['total'];

	$result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    $all_data = array();
    $i        = 0;

	while($all=$xoopsDB->fetchArray($result)){
	  	foreach($all as $k=>$v){
			$$k=$v;
		}

		$uid_name=XoopsUser::getUnameFromId($uid,1);
		if(empty($uid_name))$uid_name=XoopsUser::getUnameFromId($uid,0);

		$all_data[$i]['assn']=$assn;
		$all_data[$i]['title']=$title;
		$all_data[$i]['passwd']=$passwd;
		$all_data[$i]['uid_name']=$uid_name;
		$all_data[$i]['is_own']=($uid == $my_uid) ;
		$all_data[$i]['open_show']=$open_show;
		$all_data[$i]['upload_mode']=$upload_mode;
		$all_data[$i]['gview_mode']=$gview_mode;
		$all_data[$i]['no_file']=$no_file;
		$all_data[$i]['class_id']=$class_id;
		$i++;

	}
    	//取得中文班名
  	$class_list_c = es_class_name_list_c('long')  ;

  	$xoopsTpl->assign('class_list_c',$class_list_c);
	$xoopsTpl->assign('all_data' , $all_data);
	$xoopsTpl->assign('bar' , $bar);

}




/*-----------執行動作判斷區----------*/
$op = (!isset($_REQUEST['op']))? "":$_REQUEST['op'];

switch($op){

	//刪除資料
	case "delete_tad_assignment";
	delete_tad_assignment($_GET['assn']);
	header("location: {$_SERVER['PHP_SELF']}");
	break;


	//預設動作
	default:
	list_tad_assignment();
	break;

}

/*-----------秀出結果區--------------*/
include_once 'footer.php';
?>
