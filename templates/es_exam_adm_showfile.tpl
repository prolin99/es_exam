<{if $file_mode=='scratch3'}>
<{*  scrtach3  *}>
<style media="screen">
html, body {
  height: 100%;
}
body {
  margin: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: black;
  font-size: 0;
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  overflow: hidden;
}
#w {
  display: block;
  width: 100vw;

  height: 75vw;


  position: relative;
}
#m {
  position: absolute;
  top: 0;
  left: 0;
}

@media (min-aspect-ratio: 4/3) {
  #w {
	height: 100vh;
	width: calc(400vh / 3);
  }
}


#s {
  width: 100%;
  height: 100%;
}

#l {
  color: #0ff;
  position: fixed;
  bottom: 0;
  left: 0;
  font-size: 16px;
}


#f {
  -webkit-appearance: none;
  border: none;
  background: none;
  position: fixed;
  top: 0;
  right: 150px;
  width: 30px;
  height: 30px;
  cursor: pointer;
  background-repeat: no-repeat;
  background-position: center;
  background-size: 24px;
  background-image: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"%3E%3Cpath d="M14 28h-4v10h10v-4h-6v-6zm-4-8h4v-6h6v-4H10v10zm24 14h-6v4h10V28h-4v6zm-6-24v4h6v6h4V10H28z" fill="%23fff"/%3E%3C/svg%3E');
  background-color: rgba(0, 0, 0, 0.5);
  border-bottom-left-radius: 10px;
}
.fullscreen #f {
  background-image: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"%3E%3Cpath d="M10 32h6v6h4V28H10v4zm6-16h-6v4h10V10h-4v6zm12 22h4v-6h6v-4H28v10zm4-22v-6h-4v10h10v-4h-6z" fill="%23fff"/%3E%3C/svg%3E');
}

.monitor {
  position: absolute;
  background-color: rgba(0, 0, 0, 0.3);
  border: 1px solid rgba(0, 0, 0, 0.2);
  border-radius: 0.25rem;
  font-size: 0.75rem;
  overflow: hidden;
  padding: 3px;
  color: white;
  white-space: pre;
}
.monitor-label {
  margin: 0 5px;
  font-weight: bold;
}
.monitor-value {
  display: inline-block;
  vertical-align: top;
  min-width: 34px;
  text-align: center;
  border-radius: 0.25rem;
  overflow: hidden;
  text-overflow: ellipsis;
  user-select: text;
  transform: translateZ(0);
}
.default .monitor-value, .slider .monitor-value {
  background-color: rgba(0, 0, 0, 0.5);
  margin: 0 5px;
  padding: 1px 3px;
}
.large {
  background-color: rgba(0, 0, 0, 0.6);
  padding: 0.1rem 0.25rem;
  min-width: 3rem;
}
.large .monitor-label {
  display: none;
}
.large .monitor-value {
  font-size: 1rem;
  width: 100%;
}
.list {
  padding: 0;
  overflow: auto;
  overflow-x: hidden;
}
.list .monitor-label {
  text-align: center;
  padding: 3px;
  width: 100%;
  display: block;
  margin: 0;
  box-sizing: border-box;
  white-space: pre-wrap;
}
.list .monitor-value {
  display: block;
}
.row {
  margin: 2px 5px;
  transform: translateZ(0);
  text-align: left;
  border-radius: 0.25rem;
  background-color: rgba(0, 0, 0, 0.5);
  border: 1px solid rgba(0, 0, 0, 0.2);
  height: 20px;
  line-height: 20px;
  padding: 0 5px;
  overflow: hidden;
  text-overflow: ellipsis;
}

.slider input {
  display: block;
  width: 100%;
  transform: translateZ(0);
}
#b {
  display: none;
  position: absolute;
  left: 0;
  bottom: 0;
  right: 0;
  background-color: rgba(0, 0, 0, 0.7);
}
.asking #b {
  display: block;
}
#q {
  display: block;
  margin: 0 10px;
  margin-top: 10px;
  font-size: 12px;
  color: white;
}
#a {
  border: none;
  background: none;
  width: 100%;
  font: inherit;
  font-size: 16px;
  color: white;
  padding: 10px;
  box-sizing: border-box;
}
#a:focus {
  outline: none;
}
</style>

	<{*  scrtach3  *}>
	<div  id ="w">
	<canvas id="s"></canvas>
	<div id="m"></div>
	<div id="b">
	<label id="q" for="a">Question</label>
	<input type="text" id="a">
	</div>
	</div>

	<span id="l">...</span>
	<button id="f"></button>

	<script src="../js/vm.min.js"></script>
	<script type="text/javascript" id="j">
			//var sb3_base64  =  readSb3File('<{$file}>');
			var SRC = "file", FILE = "data:application/octet-stream;base64,<{$sb3_base64}>"   ;
			var
			DESIRED_USERNAME = "griffpatch",COMPAT = true, TURBO = false;
	</script>

	<script src="../js/play_scratch.js"></script>
<{* ----scratch3 展示 無法加入打分數畫面 ------------------------------------------------------------------------------------------------------       *}>
<{else}>


<{*  評分用的view *}>
<link rel="stylesheet" type="text/css" media="screen" href="<{$xoops_url}>/modules/tadtools/bootstrap3/css/bootstrap.css" />

<script src="<{$xoops_url}>/modules/tadtools/jquery/ui/jquery-ui.js"></script>
<link rel="stylesheet" href="<{$xoops_url}>/modules/tadtools/jquery/themes/base/jquery-ui.css">

<link rel="stylesheet" href="<{$xoops_url}>/modules/tadtools/css/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../css/star-rating.css" media="all" type="text/css"/>
<script src="../js/star-rating.js" type="text/javascript"></script>
<script src="../js/locales/zh.js" type="text/javascript"></script>
<link rel="stylesheet" href="../js/krajee-fa/theme.css" media="all" type="text/css"/>
<script src="../js/krajee-fa/theme.js" type="text/javascript"></script>


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
		<input type="text" class="fa-rating" value="<{$all.score_star}>" data-size="xs" title="" data_ref="<{$all.asfsn}>" >
		</span>
		<span class="col-xs-1 col-xs-1">
      		<input   onfocus="this.select()"   type="text"  class="score" name="score[<{$all.asfsn}>]"   id="score_<{$all.asfsn}>"  data_ref="<{$all.asfsn}>"
      		<{if ($all.score)}> value="<{$all.score}>" <{/if}> tabindex="1" placeholder='成績' title="整數成績,enter下一位，pageUp 前 ,PageDown 後" >
      		</span>
	  </span>
	</span>

<{*  ---------------------------------------------------------------------------------------------------------------------------   *}>
	<{if $file_mode=='picture'}>
	<{*  圖檔 *}>

	<div class='col-xs-12 text-center' > <img class='img-responsive  center-block' src='<{$file}>'></div>
	<div class='col-xs-12 text-center'><{  $all.memo}></div>

	<{/if}>

<{*  ---------------------------------------------------------------------------------------------------------------------------   *}>
	<{if ($file_mode=='google')}>
	<{*  pdf (google doc view ) *}>
	<div class='col-xs-12 text-center' >
		<iframe src="http://docs.google.com/gview?url=<{$file}>&embedded=true" style="width:600px; height:500px;" frameborder="0"></iframe>
		<br />
		<a href='<{$file}>' target='_blank'>如果無法查看，原始檔位置</a>
	</div><div class='col-xs-12 text-center'><{  $all.memo}></div>
	<{/if}>

<{*  ---------------------------------------------------------------------------------------------------------------------------   *}>
	<{if $file_mode=='youtube'}>
	<{*  youtube  *}>
	<div class='col-12 text-center'>
 		<iframe width="560" height="315" src="https://www.youtube.com/embed/<{$all.project_id}>"
 			frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
 		</iframe>
		<p><{$all.memo}></p>
	</div>
	<{/if}>


<{*  ---------------------------------------------------------------------------------------------------------------------------   *}>
	<{if $file_mode=='scratchWeb'}>
	<{*  scrtach web   *}>
	<div class='col-12 text-center'>
		Scratch 一套使用拖拉拼湊就可以寫程式的工具，很好玩的程式軟體。<a href='https://scratch.mit.edu/' target='_blank'>官方網站</a><br /><br />
		<br />
		<iframe allowfullscreen="" allowtransparency="false" bgcolor="#220000" height="536" scrolling="no"
		src="https://scratch.mit.edu/projects/<{$all.project_id}>/embed/"
		 width="658">
	     </iframe>
		 <p> <a href='https://scratch.mit.edu/projects/<{$all.project_id}>/' target='_blank'>原站展示</a></p>
		 <{$all.memo}>
	</div>
	<{/if}>



<{*  ---------------------------------------------------------------------------------------------------------------------------   *}>
	<{if $file_mode=='flash'}>
	<{*  scratch *}>
	<div class='col-xs-12 text-center'>
		<div id="flashContentdoc" ><{$all.memo}></div>
		<div class='row'>

				<div id="flashContent" > <br>  如未出現 Flash 畫面 <br> 請點選此處並允許執行 Flash <br> <img src="../images/flash_start.png">  <br>
				</div>
	 				<script type="text/javascript" src="../swfobject.js"></script>
					<script type="text/javascript">
					/**
					 * Tries to show browser's promt for enabling flash
					 *
					 * Chrome starting from 56 version and Edge from 15 are disabling flash
					 * by default. To promt user to enable flash, they suggest to send user to
					 * flash player download page. Then this browser will catch such request
					 * and show a promt to user:
					 * https://www.chromium.org/flash-roadmap#TOC-Developer-Recommendations
					 * In this method we are forcing such promt by navigating user to adobe
					 * site in iframe, instead of top window
					 */
					function requestFlashPermission() {
					    var iframe = document.createElement('iframe');
					    iframe.src = 'https://get.adobe.com/flashplayer';
					    iframe.sandbox = '';
					    document.body.appendChild(iframe);
					    document.body.removeChild(iframe);
					}


					var isNewEdge = (navigator.userAgent.match(/Edge\/(\d+)/) || [])[1] > 14;
					var isNewSafari = (navigator.userAgent.match(/OS X (\d+)/) || [])[1] > 9;
					var isNewChrome = (navigator.userAgent.match(/Chrom(e|ium)\/(\d+)/) || [])[2] > 56
					    && !/Mobile/i.test(navigator.userAgent);
					var canRequestPermission = isNewEdge || isNewSafari || isNewChrome;

					if (!swfobject.hasFlashPlayerVersion('10') && canRequestPermission) {
					    requestFlashPermission();
					    // Chrome requires user's click in order to allow iframe embeding
					    $(window).one('click', requestFlashPermission);
					}
					var flashvars ={};
					var params = {
					  bgcolor: "#FFFFFF",
					  allowScriptAccess: "always",
					  allowFullScreen: "true",
					  wmode: "window",
					  menu:"‘false"
					};
					var attributes = {};
					swfobject.embedSWF("<{$file}>", "flashContent", "512", "387", "11.7.0","../images/expressInstall.swf", flashvars, params, attributes);
					</script>

		</div>

	</div>
	<{/if}>

<{*  ---------------------------------------------------------------------------------------------------------------------------   *}>
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
<script type='text/javascript'>
	//星等評分
	jQuery(document).ready(function () {

		$('.fa-rating').rating({
            hoverOnClear: false ,
            language: 'zh' ,
            theme: 'krajee-fa'
        });

          $('.fa-rating').on(
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

<{/if}>
