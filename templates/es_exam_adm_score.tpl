
<link rel="stylesheet" href="<{$xoops_url}>/modules/tadtools/jquery/themes/base/jquery-ui.css">
<script src="<{$xoops_url}>/modules/tadtools/jquery/ui/jquery-ui.js"></script>

<link rel="stylesheet" href="<{$xoops_url}>/modules/tadtools/fancyBox/source/jquery.fancybox.css" type="text/css" />
<script src="<{$xoops_url}>/modules/tadtools/fancyBox/lib/jquery.mousewheel.pack.js" type="text/javascript"></script>
<script src="<{$xoops_url}>/modules/tadtools/fancyBox/source/jquery.fancybox.js" type="text/javascript"></script>



  <link rel="stylesheet" href="../css/star-rating.css" media="all" type="text/css"/>
  <script src="../js/star-rating.js" type="text/javascript"></script>



  <link href="../js/krajee-fas/theme.css" media="all" rel="stylesheet" type="text/css"/>
  <script src="../js/krajee-fas/theme.js" type="text/javascript"></script>  


<style type="text/css">
  .fancybox-nav {
     width: 10%;
   }
   </style>

  <script type='text/javascript'>
    $(document).ready(function(){
      $(".assignment_fancy_<{$assn}>").fancybox({

      openEffect: 'elastic',
      closeEffect: 'elastic',
      autoSize: true,

      'type' : 'iframe' ,
      'beforeClose': function() { window.location.reload() },
      'afterShow': function(){
          $('.fancybox-iframe').contents().find(".score").attr("tabindex",1).focus();
      } ,

      fitToView : true,
      width   : '90%',
      height    : '100%',
      padding : '30' ,
      autoSize  : true,
      closeClick  : false,

      });

      $('.fa-rating').rating({
          hoverOnClear: false ,
          theme: 'krajee-fas'
      });

    });



    function delete_func(asfsn ,stud_id){
      var sure = window.confirm('<{$smarty.const._TAD_DEL_CONFIRM}>');
      if (!sure)  return;
      location.href="score.php?op=delete_tad_assignment_file&assn=<{$assn}>&asfsn=" + asfsn   + "&stud_id=" + stud_id  ;
    }

    //
    function emp_job(assn ,class_id){
      var sure = window.confirm('這項是外部作業，會填入空作業紀錄，方便成績輸入用。');
      if (!sure)  return;
      location.href="score.php?op=emp_job&assn=<{$assn}>&stud_id=" + class_id  ;
    }




  </script>
    <{if ($exam_list) }>

<div class="container-fluid">
<h2>主題</h2>

<div class="row">
    <div class="col-6">
<form>
  <select    class="form-control"  onChange="window.location.href='score.php?assn='+this.value" >
    <option value=''><{$smarty.const._MD_TADASSIGN_SELECT_ASSN}></option>

    <{foreach from=$exam_list  item=exam_list_item}>
        <option value='<{$exam_list_item.assn}>' <{if $assn==$exam_list_item.assn}>selected<{/if}>> <{$class_list_c[$exam_list_item.class_id]}>  -- <{$exam_list_item.title}> (<{$exam_list_item.uid_name}>) </option>
      <{/foreach}>

  </select>
</form>
</div>
</div>
    <{/if  }>

<{if ($assn) }>
  <div class="row">
    <div class="col-5"><h3><{$class_list_c[$data.exam.class_id]}>   <{$data.exam.title}></h3></div>
    <div class="col-4">

    <{if  ( ($data.exam.upload_mode==0) and ($data.count_exams ==0) )}>
    <a href="javascript:emp_job(<{$assn}>,<{$data.exam.class_id}>);"  class="btn btn-danger"   title='書面(外部)作品，不上傳不展示，僅在此輸入成績使用。'>外部作品</a>
    <{/if}>
    <a class="btn btn-mono btn-success" href="export_score.php?op=class&class=<{$data.exam.class_id}>">本班學期成績</a>
    <a class="btn btn-mono btn-success" href="export_score.php?op=all">全部學期成績</a>
    </div>
    <div class="col-2 text-right">
      <button class="btn btn-warning" type="button" onClick="window.location.reload()" title='重新載入畫面'>重整</button>
       <{if    ($data.exam.upload_mode )  }>
      <a href="../index.php?assn=<{$assn}>"><button class="btn btn-primary" type="button"><{$smarty.const._MD_UPLOAD}></button></a>
      <{/if}>
    </div>
  </div>
  <div class="row"><{$data.exam.note}></div>

<div class="table-responsive-xl">
  <table class="table" id="tscore"  >
    <thead>
      <tr class='row'>
  <th class="col-1"><{$smarty.const._MD_TADASSIGN_UP_TIME}><a href='score.php?assn=<{$assn}>'><i class="fa fa-sort" aria-hidden="true"></i></a></th>
  <th class="col-2"><{$smarty.const._MD_TADASSIGN_FILENAME}></th>
  <th class="col-1">座號<a href='score.php?assn=<{$assn}>&order=num_id'><i class="fa fa-sort" aria-hidden="true"></i> </a></th>
  <th class="col-2"><{$smarty.const._MD_TADASSIGN_AUTHOR}></th>
  <th  class="col-3">評分(星等啟始分<{$base_score}>，未交<{$score_lost}>)</th>
  <th class="col-1">評語</th>
  <th class="col-2"><{$smarty.const._TAD_FUNCTION}></th>
    </tr>
    </thead>

  <tbody>
  <{if ($data.stud) }>
  <{assign var="ti" value="100"}>
  <{foreach from=$data.stud  item=all}>
  <{if ($all.old_file) }>
  <tr class='row table-danger' title='舊檔案'>
  <{else}>
  <tr class="row">
  <{/if}>
      <td  class="col-1"><{$all.up_time}><br/> <span title='<{$all.up_ip}>'>ip:..<{$all.up_ip|substr:-5}></span></td>
      <td class="col-2" style="word-break : break-all; overflow:hidden; ">
        <!--      bmp gif jpg jpeg png sb sb2 flash          -->
        <{if ($all.show_name)}>
            <{$all.show_name}>
        <{else}>
           <{if  ($data.ifram_show) }>
             <a href="show_file.php?assn=<{$all.assn}>&stud_id=<{$all.stud_id}>&asfsn=<{$all.asfsn}>&sub_name=<{$all.sub_name}>&score_bar=<{$all.score_bar}>&gv=1&old_file=<{$all.old_file}>"  studfile='<{$smarty.const._TAD_ASSIGNMENT_UPLOAD_URL}><{$all.assn}>/<{$all.asfsn}>.<{$all.sub_name}>'  class="assignment_fancy_<{$assn}>" rel="group" title="<{$all.sit_id}>.<{$all.author}> (<{$all.up_time}>) <{$all.file_name}>"  target="show"><{$all.file_name}></a>
           <{else}>
             <a href="<{$smarty.const._TAD_ASSIGNMENT_UPLOAD_URL}><{$all.assn}>/<{$all.asfsn}>.<{$all.sub_name}>"  studfile='<{$smarty.const._TAD_ASSIGNMENT_UPLOAD_URL}><{$all.assn}>/<{$all.asfsn}>.<{$all.sub_name}>'  class="assignment_fancy_<{$assn}>" rel="group" title="<{$all.sit_id}>.<{$all.author}> (<{$all.up_time}>) <{$all.file_name}>"  target="show"><{$all.file_name}></a>
           <{/if}>
        <{/if}>
       	<div id="memo_<{$all.asfsn}>" >
          <{if   ($all.memo) }>
          <i class="fa fa-window-close clean_memo" title="清除說明文字" alt="清除說明文字" data_ref="<{$all.asfsn}>" aria-hidden="true"></i>
              <{$all.memo}>
          <{/if}>
        </div>

      </td>
      <td class="col-1"><{$all.sit_id}></td>
      <td class="col-2"><{$all.author}><{if $class_students[$all.sit_id].team_sitid_list_name}> 組員：<{$class_students[$all.sit_id].team_sitid_list_rname}><{/if}> </td>

      <td  class="col-3">
      	<{*----       評分          ---- *}>
        <div class="row">
        <span class="col-7">

        <input  type="text" class="form-control fa-rating rating-loading" value="<{$all.score_star}>" data-theme="krajee-fas" data-size="xs" data-min="0" data-max="5"  data-show-clear="false" data-show-caption="true" title="" data_ref="<{$all.asfsn}>" >
        </span>
        <span class="col-3">
      		<input class="form-control score" type="text" onfocus="this.select()"   name="score[<{$all.asfsn}>]"  id="score_<{$all.asfsn}>"  data_ref="<{$all.asfsn}>"
      		<{if ($all.score)}> value="<{$all.score}>" <{/if}> tabindex="<{$ti++}>" title="整數成績">

        </span>
        <span class="col-1">
         <i  class="fa fa-question-circle" id="info_<{$all.asfsn}>" title='分數低於基本分' <{if ( ($all.score >= $base_score) or (!$all.score) )}>  style="display:none"  <{/if}>></i>
         </span>
        </div>
      </td>
      <td class="col-1">
          <input class="form-control comment" type="text" onfocus="this.select()"   name="comment[<{$all.asfsn}>]"  id="comment_<{$all.asfsn}>"  data_ref="<{$all.asfsn}>" value="<{$all.comment}>" ></input>
      </td>
      <td class="col-2">
        <a href="javascript:delete_func(<{$all.asfsn}>,<{$all.stud_id}>);" class="btn btn-mini btn-danger"><{$smarty.const._TAD_DEL}></a>
      </td>

    </tr>
  <{/foreach}>
  <{/if}>
  </tbody>
  </table>
</div>

  <h4>未上傳作業列表</h4>
  <div class="row">
  <{foreach from=$class_students  key=sit item=stud}>
  <{if (!$stud.in)  }>
 	<span class="col-2"><span class="badge badge-info bg-secondary "><{$sit }></span> <{$stud.name }>  </span>
  <{/if}>
   <{/foreach}>

</div>

</div>

<script type='text/javascript'>

    //enter 2 tab  在 #tscore 內
    //$("#tscore").enableEnterToTab({ captureTabKey: true });



 //離開才做動作寫入成績
  $(function() {
		$( ".slider" ).focusout(function(){

			var get_score =parseInt("<{$base_score}>", 10) +$(this).slider( "value" ) ;
			var v_id= $(this).attr('data_ref') ;

 			save_score('score', v_id ,  get_score    ) ;
			//alert(v_id +  get_score  );
		})		;

	});

//成績直接修改
$(function() {

	$(".score").change(function(){
		var v_id = $( this ).attr('data_ref') ;
              var get_score = $( this ).val();
              get_score = get_score.trim() ;
              $("#info_"+v_id).hide() ;
              if (get_score ) {
                  //>100 <0 歸0
                  if (  (get_score > 100) | (get_score<0)  | (! isInteger(get_score) ) ) {
                      alert (  '輸入分數有問題！') ;
                      $(this).val(0) ;
                      $(this).focus() ;
                      get_score= 0 ;
                      $("#info_"+v_id).show() ;
                  }else  {
                    // < 最低份，警告
                    if (  (get_score < parseInt("<{$base_score}>", 10) )  ) {
                        alert (  '輸入分數低於預設最低分：' + '<{$base_score}>' ) ;
                        $("#info_"+v_id).show() ;
                    }
                  }
              }
              save_score( 'score' ,v_id ,  get_score ) ;
	});
});

function isInteger(value) {
    return (value == parseInt(value));
}


//評語直接修改
$(function() {
	$(".comment").change(function(){
		var v_id = $( this ).attr('data_ref') ;
		var get_score = $( this ).val();
 		save_score( 'comment' ,v_id ,  get_score ) ;
	});
});


//把學生說明清除
$(function() {
	$(".clean_memo").on("click" , function(){
		var v_id = $( this ).attr('data_ref') ;
		var get_score = '';
    $(this).parent().hide() ;
 		save_score( 'memo' ,v_id ,  get_score ) ;
	});
});


 //寫入成績、評語
 function save_score(do_mode ,tid , sdata )  {
  	$.ajax({
 		url: 'ajax_score_exam_data.php',
 		type: 'GET',
 		data: {do: do_mode , id:tid  , setdata :sdata    },
 	})
 	.done(function(data) {
 		console.log("success");
 		//alert(data) ;
 	})
 	.fail(function() {
 		console.log("error");

 	})
 	.always(function() {
 		console.log("complete");
 	});
} ;


  </script>



<script type='text/javascript'>
      //星等評分
      jQuery(document).ready(function () {

          $('.fa-rating').on(
                  'change', function () {
                      //取得
                      var v_id= $(this).attr('data_ref') ;
                      //alert(v_id) ;
                      console.log( v_id + 'Rating selected: ' + $(this).val());
                      var rate_score = (100- <{$base_score}>) / 5 ;
                      var get_score = parseInt("<{$base_score}>", 10) + $(this).val() * rate_score ;
                      $( "#score_"+v_id ).val( get_score );
                      save_score( 'score' ,v_id ,  get_score ) ;
                  });
      });
  </script>

<{/if}>
