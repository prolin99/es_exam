<?php
use XoopsModules\Tadtools\Utility;


//需要單位名稱模組(e_stud_import)1.9

if (!file_exists(XOOPS_ROOT_PATH.'/modules/e_stud_import/es_comm_function.php')) {
    redirect_header('http://campus-xoops.tn.edu.tw/modules/tad_modules/index.php?module_sn=33', 3, '需要單位名稱模組(e_stud_import)1.9以上');
}
include_once XOOPS_ROOT_PATH.'/modules/e_stud_import/es_comm_function.php';

//------------------------------------------------------------

define('_TAD_ASSIGNMENT_UPLOAD_DIR', XOOPS_ROOT_PATH.'/uploads/es_exam/');
define('_TAD_ASSIGNMENT_UPLOAD_URL', XOOPS_URL.'/uploads/es_exam/');

//取得學生上次傳的作業 的資料
function get_stud_old_exam($assn, $class_id, $sit_id)
{
    global $xoopsDB;
    $sql = 'SELECT * FROM '.$xoopsDB->prefix('exam_files')." WHERE `assn` ='$assn' and  class_id='$class_id' and sit_id= '$sit_id'  ";
 
    $result = $xoopsDB->query($sql) ;
    while ($row = $xoopsDB->fetchArray($result)) {
        $data['old_asfsn'] = $row['asfsn'];
        $data['stud_id'] = $row['stud_id'];
        $data['memo'] = $row['memo'];
        $data['show_name'] = $row['show_name'];
    }


    return $data;
}

function exam_set_empfile($assn, $class_id)
{
    global $xoopsDB, $xoopsUser;
  //班級名單
  $sql = '  SELECT  class_sit_num , name ,stud_id  FROM '.$xoopsDB->prefix('e_student')."   where class_id='{$class_id}'  order by  class_sit_num  ";
    $result = $xoopsDB->query($sql)  ;
    while ($row = $xoopsDB->fetchArray($result)) {
        $class_students[$row['class_sit_num']] = $row;
    }
    $class_students_r = array_reverse($class_students, true);

    foreach ($class_students_r  as $sit_id => $stud) {
        $sql = ' insert into  '.$xoopsDB->prefix('exam_files')."  (  `asfsn`, `assn`, `class_id`, `sit_id`, `stud_id`, `file_name`, `file_size`, `file_type`, `show_name`, `memo`, `author`, `score`, `comment`, `up_time` )
          values ( '0', $assn,  '$class_id' ,$sit_id , '{$stud['stud_id']}' ,'' ,0 , '' ,'' , '外部作業' ,  '{$stud['name']}' ,'0' , '' , now()  ) ";
        $result = $xoopsDB->queryF($sql) or die($sql.'<br>'.$xoopsDB->error());
    }
}

function get_exam_list($mode, $order = ' class_id ,  assn desc', $semester = 1)
{
    global $xoopsDB, $xoopsUser;
    if ($semester) {
        //只出現這學期的作業 0201  or 08/01
        if (date('m') >= 2 and date('m') < 8) {
            $beg_date = date('Y-m-d', mktime(0, 0, 0, 2, 1, date('Y')));
        } elseif (date('m') < 2) {
            $beg_date = date('Y-m-d', mktime(0, 0, 0, 8, 1, date('Y') - 1));
        } else {
            $beg_date = date('Y-m-d', mktime(0, 0, 0, 8, 1, date('Y')));
        }
        $and_date_sql = "  and   create_date>=$beg_date	";
    }
    if ($mode == 'upload') {
        $sql_and = " and upload_mode ='1' ";
    }
    if ($mode == 'show') {
        $sql_and = "  and open_show ='1'  ";
    }

    //教師，只列出自已開設的作業
    if ($mode == 'teacher') {
        $my_uid = $xoopsUser->uid();
        $sql_and = " and uid ='$my_uid'  ";
    }

    $sql = 'select assn,title,uid , class_id,open_show  from '.$xoopsDB->prefix('exam')." where 1    $sql_and     $and_date_sql   order by  $order    ";
 //echo $sql ;
  $result = $xoopsDB->query($sql) ;
    $i = 0;
    $data = array();
    while (list($assn, $title, $uid, $class_id, $open_show) = $xoopsDB->fetchRow($result)) {
        $uid_name = XoopsUser::getUnameFromId($uid, 1);
        if (empty($uid_name)) {
            $uid_name = XoopsUser::getUnameFromId($uid, 0);
        }
        $data[$i]['assn'] = $assn;
        $data[$i]['title'] = $title;
        $data[$i]['uid_name'] = $uid_name;
        $data[$i]['class_id'] = $class_id;
        $data[$i]['open_show'] = $open_show;

        ++$i;
    }

    return  $data;
}

//列出所有tad_assignment_file資料
function list_exam_file($assn = '', $my_order = ' `up_time` DESC , sit_id ASC ')
{
    global $xoopsDB,$xoopsModule,$isAdmin,$xoopsTpl ,$xoopsModuleConfig;

    $base_score = $xoopsModuleConfig['ESEXAM_BASE'];

  //作業主題
  $DBV = get_tad_assignment($assn);
    foreach ($DBV as $k => $v) {
        $$k = $v;
        $xoopsTpl->assign($k, $v);
    }

  //班級名單
  $sql = '  SELECT  class_sit_num , name  FROM '.$xoopsDB->prefix('e_student')."   where class_id='{$class_id}'  order by  class_sit_num  ";
    $result = $xoopsDB->query($sql)  ;
    while ($row = $xoopsDB->fetchArray($result)) {
        $class_students[$row['class_sit_num']]['name'] = $row['name'];
    }
  //$xoopsTpl->assign('class_students',$class_students);

  //個人作品
  $sql = 'select * from '.$xoopsDB->prefix('exam_files')." where assn='{$assn}' order by $my_order  ";
    $result = $xoopsDB->query($sql)  ;

    $i = 0;

    while ($all = $xoopsDB->fetchArray($result)) {
        foreach ($all as $k => $v) {
            $$k = $v;
            $data[$i][$k] = $v;
        }

        //作品說明做處理
        $myts = &MyTextSanitizer::getInstance();
        $data[$i]['memo'] = $myts->displayTarea($data[$i]['memo']);

        //上傳網址放在 show_name ， 檢查是否可做 iframe     iframe title:  $assn , $sit_id .'.' . $author  . $up_time
        if ($show_name){
            $d = get_url_iframe($show_name, $asfsn , $assn , $sit_id .'.' . $author  . $up_time) ;
            $show_name= $d['link'] ;

        }

        $filepart = explode('.', $file_name);
        foreach ($filepart as $ff) {
            $sub_name = strtolower($ff);
        }
        //無附檔名
        if (count($filepart) <=1)
          $sub_name='txt' ;

        //檔案可以 iframe
        if (preg_match('/(jpg|jpeg|swf|bmp|png|gif|sb|sb2|svg|pdf)/i', $sub_name)) {
            $show_name ="<a href='show_file.php?asfsn=$asfsn&sub_name=$sub_name' class='assignment_fancy_$assn' rel='group' target='show'>$file_name</a>" ;
        }

        $data[$i]['sub_name'] = $sub_name;
        $data[$i]['show_name'] = $show_name;


        //作品座號標記
        $class_students[$sit_id]['in'] = 1;

        //判別是否有多個檔案 後面的為舊檔
        if ($files_has[$stud_id])
            $data[$i]['old_file'] = 1 ;
        else {
            $files_has[$stud_id] = 1 ;
            $data[$i]['old_file'] = 0 ;
        }

        //成績 bar
        $data[$i]['score_bar'] = $data[$i]['score'] - $base_score;
        if ($data[$i]['score_bar'] < 0) {
            $data[$i]['score_bar'] = 0;
        }
        //星級
        $data[$i]['score_star'] = ($data[$i]['score'] - $base_score) / ((100 - $base_score) / 5);
        if ($data[$i]['score_star'] < 0) {
            $data[$i]['score_star'] = 0;
        }

        ++$i;
    }
    $xoopsTpl->assign('class_students', $class_students);

    return $data;
}

function list_one_exam($asfsn)
{
    global $xoopsDB,$xoopsModule,$isAdmin,$xoopsTpl ,$xoopsModuleConfig;

    $base_score = $xoopsModuleConfig['ESEXAM_BASE'];
    //個人作品
  $sql = 'select * from '.$xoopsDB->prefix('exam_files')." where asfsn='{$asfsn}'   ";

    $result = $xoopsDB->query($sql)  ;

    $data = array();
    while ($all = $xoopsDB->fetchArray($result)) {
        foreach ($all as $k => $v) {
            $$k = $v;
            $data[$k] = $v;
        }
    }

    //成績 bar
    $data['score_bar'] = $data['score'] - $base_score;
    if ($data['score_bar'] < 0) {
        $data['score_bar'] = 0;
    }
    //星級
    $data['score_star'] = ($data['score'] - $base_score) / ((100 - $base_score) / 5);

    if ($data['score_star'] < 0) {
        $data['score_star'] = 0;
    }

    return $data;
}

//以流水號取得某筆tad_assignment資料
function get_tad_assignment($assn = '')
{
    global $xoopsDB;
    if (empty($assn)) {
        return;
    }
    $sql = 'select * from '.$xoopsDB->prefix('exam')." where assn='$assn'";

    $result = $xoopsDB->query($sql) ;
    $data = $xoopsDB->fetchArray($result);

    return $data;
}

//轉換成時間戳記
function day2ts($day = '', $sy = '-')
{
    if (empty($day)) {
        $day = date('Y-m-d H:i:s');
    }
    $dt = explode(' ', $day);

    $d = explode($sy, $dt[0]);
    $t = explode(':', $dt[1]);

    $ts = mktime($t['0'], $t['1'], $t['2'], $d['1'], $d['2'], $d['0']);

    return $ts;
}



//刪除 exam 某筆資料資料
function delete_tad_assignment($assn = '')
{
    global $xoopsDB;
    //exam
    $sql = 'delete from '.$xoopsDB->prefix('exam')." where assn='$assn'";
    $xoopsDB->queryF($sql)  ;

    //exam_files
    $sql = 'delete from '.$xoopsDB->prefix('exam_files')." where assn='$assn'";
    $xoopsDB->queryF($sql)  ;

    //刪除目錄
    Utility::delete_directory(_TAD_ASSIGNMENT_UPLOAD_DIR."{$assn}");
}

//刪除 exam_files 某筆資料資料
function delete_tad_assignment_file($asfsn = '', $stud_id)
{
    global $xoopsDB;

    $sql = 'select * from '.$xoopsDB->prefix('exam_files')." where asfsn='{$asfsn}'    and stud_id = '$stud_id'   ";
    //   echo  $sql ; exit ;
    $result = $xoopsDB->query($sql)  ;

    while ($all = $xoopsDB->fetchArray($result)) {
        foreach ($all as $k => $v) {
            $$k = $v;
        }
    }

    $filepart = explode('.', $file_name);
    foreach ($filepart as $ff) {
        $sub_name = strtolower($ff);
    }

    unlink(_TAD_ASSIGNMENT_UPLOAD_DIR."{$assn}/{$asfsn}.{$sub_name}");

    $sql = 'delete from '.$xoopsDB->prefix('exam_files')." where asfsn='$asfsn'";
    $xoopsDB->queryF($sql) ;
}

//標記  exam_files 某筆檔案為舊版本
function mark_old_tad_assignment_file($asfsn = '', $stud_id)
{
    global $xoopsDB;

    $sql = 'update   '.$xoopsDB->prefix('exam_files')." set old_file = 1  where asfsn='$asfsn'  ";

    $xoopsDB->queryF($sql) ;
}

/********************* 預設函數 *********************/

function get_class_list()
{
    //取得全校班級列表
    global  $xoopsDB;

    $sql = '  SELECT  class_id  FROM '.$xoopsDB->prefix('e_student').'   group by class_id   ';

    $result = $xoopsDB->query($sql)  ;
    while ($row = $xoopsDB->fetchArray($result)) {
        $data[$row['class_id']] = $row['class_id'];
    }

    return $data;
}

function get_stud_name($class_id, $sit_id)
{
    //取得學生姓名，stud_id
    global  $xoopsDB;

    $sql = '  SELECT  stud_id , name  FROM '.$xoopsDB->prefix('e_student')."   where class_id='$class_id' and class_sit_num='$sit_id'  ";

    $result = $xoopsDB->query($sql)  ;
    while ($row = $xoopsDB->fetchArray($result)) {
        $data = $row;
    }

    return $data;
}


function get_url_iframe($url ,$asfsn=0 , $assn=0 ,$author_title='' ){

    $myts = &MyTextSanitizer::getInstance();
    if (preg_match('/^https:\/\/scratch.mit.edu\/projects\/(\d+)/',trim($url) ,$matches ) ) {
        $project_id = $matches[1] ;
        $d['mode']= 'scratch3';
        $d['project_id']= $project_id;
        $d['link'] ="<a href='show_file.php?asfsn=$asfsn' class='assignment_fancy_$assn' rel='group' target='show' title='$author_title' >scratch專案 $project_id</a>" ;
        //echo $d['link'] ;
    }elseif (preg_match('/^https:\/\/www.youtube.com\/watch\?v\=(.*)/',trim($url),$matches  ) ) {
        $project_id = $matches[1] ;
        $d['mode']= 'youtube';
        $d['project_id']= $project_id;
        $d['link'] ="<a href='show_file.php?asfsn=$asfsn' class='assignment_fancy_$assn' rel='group' target='show' title='$author_title' >youtube影片 $project_id</a>" ;
    }else{
        $d['link']= $show_name = $myts->displayTarea($url);
    }
    return $d ;
}
