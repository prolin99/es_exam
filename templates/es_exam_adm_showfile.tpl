<{*  評分用的view *}>
<link rel="stylesheet" type="text/css" media="screen" href="<{$xoops_url}>/modules/tadtools/bootstrap3/css/bootstrap.css" />
<script src="<{$xoops_url}>/modules/tadtools/jquery/jquery-migrate-3.0.0.min.js" type="text/javascript"></script>

<script src="<{$xoops_url}>/modules/tadtools/jquery/ui/jquery-ui.js"></script>
<link rel="stylesheet" href="<{$xoops_url}>/modules/tadtools/jquery/themes/base/jquery-ui.css">

<link rel="stylesheet" href="<{$xoops_url}>/modules/tadtools/css/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../css/star-rating.css" media="all" type="text/css"/>
<link rel="stylesheet" href="../css/theme-krajee-fa.css" media="all" type="text/css"/>
<script src="../css/star-rating.js" type="text/javascript"></script>
<{ if ($old_file) }>
	<div class='row alert-danger' title='舊檔案'>
<{else}>
	<div class='row'>
<{/if}>
	<span class="alert alert-success row"  title='左右邊界處，滑鼠滾軸，可切換上下張。'>
	  <span class=" col-xs-10 col-xs-offset-1">
		  <span class="col-xs-1 col-xs-1">
			ip..<{$all.up_ip|substr:-5}>
		  </span>
		<span class="col-xs-3">
		<input class="comment" type="text" onfocus="this.select()"   name="comment[<{$all.asfsn}>]"  id="comment_<{$all.asfsn}>"  data_ref="<{$all.asfsn}>" value="<{$all.comment}>" placeholder='評語'  title="評語">
		</span>
		<span class="col-xs-5">
		<input type="text" class="kv-fa rating-loading" value="<{$all.score_star}>" data-size="xs" title="" data_ref="<{$all.asfsn}>" >
		</span>
		<span class="col-xs-1 col-xs-1">
      		<input   onfocus="this.select()"   type="text"  class="score" name="score[<{$all.asfsn}>]"   id="score_<{$all.asfsn}>"  data_ref="<{$all.asfsn}>"
      		<{if ($all.score)}> value="<{$all.score}>" <{/if}> tabindex="1" placeholder='成績' title="整數成績,enter下一位，pageUp 前 ,PageDown 後" >
      		</span>
	  </span>
	</span>

	<{if $file_mode=='picture'}>
	<{*  圖檔 *}>

	<div class='col-xs-12 text-center' > <img class='img-responsive  center-block' src='<{$file}>'></div>
	<div class='col-xs-12 text-center'><{  $all.memo}></div>

	<{/if}>


	<{if ($file_mode=='google')}>
	<{*  pdf (google doc view ) *}>
	<div class='col-xs-12 text-center' >
		<iframe src="http://docs.google.com/gview?url=<{$file}>&embedded=true" style="width:600px; height:500px;" frameborder="0"></iframe>
		<br />
		<a href='<{$file}>' target='_blank'>如果無法查看，原始檔位置</a>
	</div><div class='col-xs-12 text-center'><{  $all.memo}></div>
	<{/if}>


	<{if $file_mode=='scratch'}>
	<{*  scratch *}>
	<div   class='col-xs-12 text-center'>

		<div class="row">
		<div class='col-xs-8 text-center col-xs-offset-2'>
			<div class="embed-responsive embed-responsive-16by9">
			    <iframe class="embed-responsive-item" src="<{$xoops_url}>/modules/es_exam/images/Scratch.swf?project=<{$file}>&autostart=flase"></iframe>
			</div>
		</div>
		</div>
		<div id="flashContent" >

		<a href='<{$file}>'>作品下載</a><br />
		使用說明：<br />
		<{$all.memo}>
		</div>
	</div>


	<{/if}>

	<{if $file_mode=='flash'}>
	<{*  scratch *}>
	<div class='col-xs-12 text-center'>
		<div id="flashContent" ><{$all.memo}></div>
		<div class='row'>
			<div class="embed-responsive embed-responsive-16by9">
			    <iframe class="embed-responsive-item" src="<{$file}>?autostart=flase"></iframe>
			</div>
		</div>

	</div>
	<{/if}>

	<{if $file_mode=='pdf'}>
	<{*  pdf *}>
	<div class='col-xs-12 text-center'>
 		<div id="pdfContent" ><a href="<{$file}>" target="_blank">下載檔案</a>.</p> <p> <{  $all.memo}></p></div>
		<div class="embed-responsive embed-responsive-16by9">
	       <object class="embed-responsive-item" data="<{$file}>" type="application/pdf" internalinstanceid="9" title="">
	           <p>Your browser isn't supporting embedded pdf files. You can download the file
	               <a href="<{$file}>">here</a>.</p>
	       </object>
	    </div>

 	</div>


	<{/if}>


</div>

<script  >
/*
 $(function() {
    var spinner = $( "#score_<{$all.asfsn}>" ).spinner({ 	min: 0, max: 100     }) ;

  });

 $( "#score_<{$all.asfsn}>" ).on("spinstop", function(){
   $(this).change();
});
 */
  //分數拉條
  $(function() {
		$( ".slider" ).slider({
 			slide: function( event, ui ) {
 				var v_id= $(this).attr('data_ref')
				$( "#score_"+v_id ).val(  parseInt("<{$base_score}>", 10) + ui.value );
			}});


	});

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
	$(".score").keydown(function(event){

		//pagedown or enter
		if ( event.which ==34 ||  event.which ==13 ) {
			$(this).change() ;
  			parent.$.fancybox.next() ;
		}
		//pageUp
		if ( event.which ==33) {
			$(this).change() ;
 			parent.$.fancybox.prev() ;
		}
	});

	$(".score").change(function(){
		var v_id = $( this ).attr('data_ref') ;
		var get_score = $( this ).val();
		//alert(get_score) ;
		get_score = get_score.trim() ;
    	 	if (get_score ) {
  			if  ( get_score < parseInt("<{$base_score}>", 10)  )
  				alert (  '分數低於基本分:' +"<{$base_score}>" ) ;
    	   		if (  (get_score > 100) | (get_score<0)  | (! isInteger(get_score) ) ) {
    	   			alert (  '輸入分數有問題！') ;
    	   			$(this).val(0) ;
    	   			$(this).focus() ;
    	   			get_score= 0 ;
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
  }


  </script>﻿
  <script>
      //星等評分
      $(document).on('ready', function () {


          $('.kv-fa').rating({
              theme: 'krajee-fa',
              starCaptions: function (rating) {
                  return rating =  rating + '';
              },
              //不出現 no rated
              clearCaption : '' ,
              //showClear: false,
							containerClass: 'is-star' ,
              filledStar: '<i class="fa fa-star"></i>',
              emptyStar: '<i class="fa fa-star-o"></i>'
          });



          $('.kv-fa').on(
                  'change', function () {
                      //取得
                      var v_id= $(this).attr('data_ref') ;
                      console.log( v_id + 'Rating selected: ' + $(this).val());
                      var rate_score = (100- <{$base_score}>) / 5 ;
                      var get_score = parseInt("<{$base_score}>", 10) + $(this).val() * rate_score ;
                      $( "#score_"+v_id ).val( get_score );
                      save_score( 'score' ,v_id ,  get_score ) ;
                  });
      });
  </script>
