<?php
/*-----------�ޤJ�ɮװ�--------------*/
$xoopsOption['template_main'] = "es_exam_adm_main.html";
include_once "header.php";
include_once "../function.php";
/*-----------function��--------------*/


//�C�X�Ҧ�tad_assignment���
function list_tad_assignment($show_function=1){
	global $xoopsDB,$xoopsModule,$xoopsTpl;
	$sql = "select * from ".$xoopsDB->prefix("exam")." order by class_id,  assn desc";

	//PageBar(��Ƽ�, �C����ܴX�����, �̦h��ܴX�ӭ��ƿﶵ);
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	$total=$xoopsDB->getRowsNum($result);

	$navbar = new PageBar($total, 20, 10);
	$mybar = $navbar->makeBar();
	$bar= sprintf(_TAD_TOOLBAR,$mybar['total'],$mybar['current'])."{$mybar['left']}{$mybar['center']}{$mybar['right']}";
	$sql.=$mybar['sql'];

	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

	$data="";
  $i=0;
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
    $all_data[$i]['open_show']=$open_show;
    $all_data[$i]['upload_mode']=$upload_mode;
    $all_data[$i]['class_id']=$class_id;
    $i++;

	}

	$xoopsTpl->assign('all_data' , $all_data);
	$xoopsTpl->assign('bar' , $bar);

}


//�R��tad_assignment�Y����Ƹ��
function delete_tad_assignment($assn=""){
	global $xoopsDB;
	$sql = "delete from ".$xoopsDB->prefix("exam")." where assn='$assn'";
	$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
}

/*-----------����ʧ@�P�_��----------*/
$op = (!isset($_REQUEST['op']))? "":$_REQUEST['op'];

switch($op){

	//�R�����
	case "delete_tad_assignment";
	delete_tad_assignment($_GET['assn']);
	header("location: {$_SERVER['PHP_SELF']}");
	break;


	//�w�]�ʧ@
	default:
	list_tad_assignment();
	break;

}

/*-----------�q�X���G��--------------*/
include_once 'footer.php';
?>
