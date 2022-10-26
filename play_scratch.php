<?php

/*-----------引入檔案區--------------*/

include 'header.php';

include_once XOOPS_ROOT_PATH.'/header.php';

/*-----------function區--------------*/


$asfsn = intval($_GET['asfsn']);

//取得作業
$data = list_one_exam($asfsn);


$filepart = explode('.', $data['file_name']);
foreach ($filepart as $ff) {
    $sub_name = strtolower($ff);
}
$file =_TAD_ASSIGNMENT_UPLOAD_URL.$data['assn'].'/'.$data['asfsn'].'.'.$sub_name;
//$file = "../../uploads/es_exam/".$data['assn'].'/'.$data['asfsn'].'.'.$sub_name;
$realFile = _TAD_ASSIGNMENT_UPLOAD_DIR.$data['assn'].'/'.$data['asfsn'].'.'.$sub_name;

//die( $realFile   );

if (preg_match('/(sb|sb2|sb3)/i', $sub_name)) {
    $sb3ExtPath = _TAD_ASSIGNMENT_UPLOAD_DIR.$data['assn'].'/'.$data['asfsn'] ;
    $file_mode = 'scratch3';
    //$sb3_base64 =base64_encode( file_get_contents($file) );

    //如果已解開過，就不再解壓
    if ( !is_dir( $sb3ExtPath   ) ) {

        $zip = new ZipArchive;
        $res = $zip->open( $realFile );
        if ($res === TRUE) {
            $zip->extractTo( $sb3ExtPath );
            $zip->close();
        } 

    }
}

/*-----------秀出結果區--------------*/

$xoopsTpl = new \XoopsTpl();


//$xoopsTpl->assign('sb3_base64', $sb3_base64);
$xoopsTpl->assign('sb3_path',  '../../uploads/es_exam/'.$data['assn'].'/'.$data['asfsn'].'/' );

$xoopsTpl->display('db:es_exam_scratch.tpl');