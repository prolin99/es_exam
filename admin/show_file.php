<?php
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "es_exam_adm_score.html";
include_once "header.php";
include_once "../function.php";

	//基本分，拉bar 值
	$base_score= $xoopsModuleConfig['ESEXAM_BASE'] ;
	$bar_max=100- $base_score ;
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Title Page</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" media="screen" href="<{$xoops_url}>/modules/tadtools/bootstrap/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<{$xoops_url}>/modules/tadtools/bootstrap/css/bootstrap-responsive.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<{$xoops_url}>/modules/tadtools/css/xoops_adm.css" />
<link rel="stylesheet" href="<?php echo XOOPS_URL  ?>/modules/tadtools/jquery/themes/base/jquery-ui.css">
<script src="<?php echo XOOPS_URL  ?>/modules/tadtools/jquery/ui/jquery-ui.js"></script>    
  </head>
  <body>
<?php
/*-----------function區--------------*/

$ext_file = $_GET['sub_name'] ; 
$asfsn = intval($_GET['asfsn'] ); 
$score_bar = intval($_GET['score_bar'] ); 

$file = _TAD_ASSIGNMENT_UPLOAD_URL. $_GET['assn'] . '/' . $_GET['asfsn'] . '.' . $_GET['sub_name'] ;
if (preg_match('/(jpg|jpeg|bmp|gif|png)/i'  ,$ext_file )  ) 
	echo  "<div class='row-fluid'><div class='span7 offset5'> <img src='$file'></div></div>" ;
?>
<div class='row-fluid'>
	<div class="span7 offset5">   
 	<script>$( "#slider_<?php echo  asfsn ?>" ).slider({value: <?php echo  score_bar ?>, min: 0,max: <?php echo $bar_max ?>}) </script>
      		<input class="span1 score" type="text" onfocus="this.select()"   name="score[<{$all.asfsn}>]"  id="score_<{$all.asfsn}>"  data_ref="<{$all.asfsn}>"  
      		<{if ($all.score)}> value="<{$all.score}>" <{/if}> tabindex="<{$ti++}>" title="可直接輸入整數成績">
	</div >            		
</div >      		
  </body>
</html>