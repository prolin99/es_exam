<?php
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "es_exam_adm_score.html";
include_once "header.php";
include_once "../function.php";
/*-----------function區--------------*/

 
$file = _TAD_ASSIGNMENT_UPLOAD_URL. $_GET['assn'] . '/' . $_GET['asfsn'] . '.' . $_GET['sub_name'] ;
echo  "<img src='$file'>" ;
/*-----------秀出結果區--------------*/
//include_once 'footer.php';
?>