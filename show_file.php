<?php

/*-----------引入檔案區--------------*/

include 'header.php';

include_once XOOPS_ROOT_PATH.'/header.php';

/*-----------function區--------------*/

$ext_file = $_GET['sub_name'];
$asfsn = intval($_GET['asfsn']);
$score_bar = intval($_GET['score_bar']);

//取得作業
$data = list_one_exam($asfsn);

    //作品說明做處理
$myts = &MyTextSanitizer::getInstance();
$data['memo'] = $myts->displayTarea($data['memo']);

$file = _TAD_ASSIGNMENT_UPLOAD_URL.$data['assn'].'/'.$data['asfsn'].'.'.$_GET['sub_name'];

if (preg_match('/(jpg|jpeg|bmp|png|gif|svg)/i', $ext_file)) {
    $file_mode = 'picture';
}

if (preg_match('/(sb|sb2)/i', $ext_file)) {
    $file_mode = 'scratch';
}

if (preg_match('/(swf)/i', $ext_file)) {
    $file_mode = 'flash';
}
if (preg_match('/(pdf)/i', $ext_file)) {
    $file_mode = 'pdf';
}
/*-----------秀出結果區--------------*/

$xoopsTpl = new XoopsTpl();

  $xoopsTpl->assign('base_score', $base_score);
  $xoopsTpl->assign('bar_max', $bar_max);
  $xoopsTpl->assign('score_lost', $score_lost);
  $xoopsTpl->assign('all', $data);

$xoopsTpl->assign('file', $file);
$xoopsTpl->assign('file_mode', $file_mode);
//內包樣版
$xoopsTpl->assign('module_dir', $xoopsModule->dirname());
$xoopsTpl->assign('html_file', 'es_exam_showfile_view.html');

$xoopsTpl->display('db:es_exam_empt.html');
