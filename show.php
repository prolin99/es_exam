<?php
/*
// Cross-Origin Resource Sharing Header
header('Access-Control-Allow-Origin: http://120.116.24.96:8000');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept');
*/
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
include 'header.php';
$xoopsOption['template_main'] = 'es_exam_show.tpl';
include_once XOOPS_ROOT_PATH.'/header.php';

/*-----------function區--------------*/
//列出所有tad_assignment資料
function list_tad_assignment_menu()
{
    global $xoopsDB,$xoopsModule,$isAdmin,$xoopsTpl;

    //取得中文班名
  $class_list_c = es_class_name_list_c('long');

    $alldata = get_exam_list('');

    $xoopsTpl->assign('class_list_c', $class_list_c);
    $xoopsTpl->assign('select_assn_all', $alldata);
}

//列出所有tad_assignment_file資料
function list_tad_assignment_file($assn = '', $order='')
{
    global $xoopsDB,$xoopsModule,$isAdmin,$xoopsTpl  ,$xoopsModuleConfig;

    $DBV = get_tad_assignment($assn);
    foreach ($DBV as $k => $v) {
        $$k = $v;
        $xoopsTpl->assign($k, $v);
    }

    if ($order=='num_id')
      $sql = 'select * from '.$xoopsDB->prefix('exam_files')." where assn='{$assn}' order by sit_id ";
    else
      $sql = 'select * from '.$xoopsDB->prefix('exam_files')." where assn='{$assn}' order by `up_time`  DESC ,sit_id ";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, $xoopsDB->error());

    $i = 0;
  //$data="";
  //拉bar秀成績，低限
  //$bar_base_score = 51;
  $bar_base_score = $xoopsModuleConfig['ESEXAM_BASE'];

    while ($all = $xoopsDB->fetchArray($result)) {
        foreach ($all as $k => $v) {
            $$k = $v;
            $data[$i][$k] = $v;
        }
        //只出現姓
        $data[$i]['author'] = mb_substr($data[$i]['author'], 0, 1, 'UTF-8').'同學';

        //分數拉bar 7 等份
        if ($data[$i]['score']) {
            $data[$i]['bar'] = floor(($data[$i]['score'] - $bar_base_score) / ((100 - $bar_base_score) / 7)) * 14 + 10;
            $data[$i]['score_star'] = ($data[$i]['score'] - $bar_base_score) / ((100 - $bar_base_score) / 5);
        }

        //作品說明做處理
        $myts = &MyTextSanitizer::getInstance();
        $data[$i]['memo'] = $myts->displayTarea($data[$i]['memo']);

        //上傳網址放在 show_name ， 檢查是否可做 iframe
        if ($show_name){
            $d = get_url_iframe($show_name, $data[$i]['asfsn'] , $data[$i]['assn']  ,$data[$i]['sit_id'] . '.' . $data[$i]['author']  . $data[$i]['up_time']  ) ;
            $show_name= $d['link'] ;
            //echo $show_name ;
        }

        $filepart = explode('.', $file_name);
        foreach ($filepart as $ff) {
            $sub_name = strtolower($ff);
        }
        if (count($filepart??[]) <=1)
          $sub_name='txt' ;

        //檔案可以 iframe
        if (preg_match('/(sb|sb2|sb3|swf|pdf)/i', $sub_name)) {
          //$show_name ="<a href='show_file.php?asfsn={$data[$i]['asfsn']}&sub_name=$sub_name' class='assignment_fancy_{$data[$i]['assn']}' rel='group' target='show' >$file_name</a>" ;
          $ifram_show=1 ;
        }


        $data[$i]['sub_name'] = $sub_name;
        $data[$i]['show_name'] = $show_name;
        //
        $ip_split = preg_split("/[:.]+/", $data[$i]['up_ip']);
        $data[$i]['up_ip_all'] =  $data[$i]['up_ip'] ;
        $data[$i]['up_ip'] =  end($ip_split) ;
        //$data[$i]['up_ip'] = substr($data[$i]['up_ip'],-7)  ;
        //判別是否有多個檔案 後面的為舊檔
        if ($files_has[$stud_id])
            $data[$i]['old_file'] = 1 ;
        else {
            $files_has[$stud_id] = 1 ;
            $data[$i]['old_file'] = 0 ;
        }

        ++$i;
    }

    //取得作業
    $stud = list_exam_file($assn);

    $xoopsTpl->assign('title', $title);
    $xoopsTpl->assign('assn', $assn);
    $xoopsTpl->assign('file_data', $data);
    $xoopsTpl->assign('now_op', 'list_tad_assignment_file');
    $xoopsTpl->assign('ifram_show', $ifram_show);
    $xoopsTpl->assign('file_mode', $file_mode);
}

/*-----------執行動作判斷區----------*/
$_REQUEST['op'] = (empty($_REQUEST['op'])) ? '' : $_REQUEST['op'];
$assn = (!isset($_REQUEST['assn'])) ? '' : intval($_REQUEST['assn']);
$asfsn = (!isset($_REQUEST['asfsn'])) ? '' : intval($_REQUEST['asfsn']);
$stud_id = (!isset($_REQUEST['stud_id'])) ? '' : intval($_REQUEST['stud_id']);

switch ($_REQUEST['op']) {

  //刪除資料
  case 'delete_tad_assignment_file':
  delete_tad_assignment_file($asfsn, $stud_id);
  header("location: show.php?assn=$assn");
  break;

  default:

  list_tad_assignment_menu();

  if (!empty($assn)) {
      list_tad_assignment_file($assn ,$_GET['order']);
  }
  break;
}


/*-----------秀出結果區--------------*/
$xoopsTpl->assign('toolbar', Utility::toolbar_bootstrap($interface_menu));
$xoopsTpl->assign('bootstrap', Utility::get_bootstrap());
$xoopsTpl->assign('jquery', Utility::get_jquery(true));
$xoopsTpl->assign('isAdmin', $isAdmin);
$xoopsTpl->assign('assn', $assn);

include_once XOOPS_ROOT_PATH.'/footer.php';
