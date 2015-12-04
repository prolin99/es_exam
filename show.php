<?php

/*-----------引入檔案區--------------*/
include 'header.php';
$xoopsOption['template_main'] = set_bootstrap('es_exam_show.html');
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
function list_tad_assignment_file($assn = '')
{
    global $xoopsDB,$xoopsModule,$isAdmin,$xoopsTpl  ,$xoopsModuleConfig;

    $DBV = get_tad_assignment($assn);
    foreach ($DBV as $k => $v) {
        $$k = $v;
        $xoopsTpl->assign($k, $v);
    }

    $sql = 'select * from '.$xoopsDB->prefix('exam_files')." where assn='{$assn}' order by `up_time` DESC ";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());

    $i = 0;
  //$data="";
  //拉bar秀成績，低限
  $bar_base_score = 51;

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
    }

    //作品說明做處理
    $myts = &MyTextSanitizer::getInstance();
        $data[$i]['memo'] = $myts->displayTarea($data[$i]['memo']);

        $show_name = (empty($show_name)) ? $author._MD_TADASSIGN_UPLOAD_FILE : $show_name;
        $filepart = explode('.', $file_name);
        foreach ($filepart as $ff) {
            $sub_name = strtolower($ff);
        }

        $data[$i]['sub_name'] = $sub_name;
        $data[$i]['show_name'] = $show_name;

        ++$i;
    }

    if (preg_match('/(sb|sb2)/i', $ext_file)) {
        $ifram_show = 1;
        $file_mode = 'scratch';
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
      list_tad_assignment_file($assn);
  }
  break;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('toolbar', toolbar_bootstrap($interface_menu));
$xoopsTpl->assign('bootstrap', get_bootstrap());
$xoopsTpl->assign('jquery', get_jquery(true));
$xoopsTpl->assign('isAdmin', $isAdmin);

include_once XOOPS_ROOT_PATH.'/footer.php';
