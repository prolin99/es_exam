
<!-- bootstrap4 -->
<link href="<{$xoops_url}>/modules/tadtools/bootstrap4/css/bootstrap.css" rel="stylesheet" media="all">
<!-- SmartMenus jQuery Bootstrap Addon CSS -->
<link href="<{$xoops_url}>/modules/tadtools/smartmenus/addons/bootstrap-4/jquery.smartmenus.bootstrap-4.css" media="all" rel="stylesheet">
<!-- font-awesome -->
<link href="<{$xoops_url}>/modules/tadtools/css/font-awesome/css/font-awesome.css" rel="stylesheet" media="all">

    <{*  ---------------------------------------------------------------------------------------------------------------------------   *}>
	<{if $file_mode=='picture'}>
	<{*  圖檔 *}>
	<div class='row' id ="w">
	<div class='col-12 text-center'> <img class='img-fluid' src='<{$file}>'></div><div><{  $all.memo}></div>
	</div>
	<{/if}>

 <{*  ---------------------------------------------------------------------------------------------------------------------------   *}>
	<{if $file_mode=='youtube'}>
	<{*  youtube  *}>
	<div class='row' id ="w">
	<div class='col-12 text-center'>
 		<iframe width="560" height="315" src="https://www.youtube.com/embed/<{$all.project_id}>"
 			frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
 		</iframe>
		<p><{$all.memo}></p>
	</div>
	</div>
	<{/if}>


<{*  ---------------------------------------------------------------------------------------------------------------------------   *}>
	<{if $file_mode=='scratch3'}>
	<{*  scrtach3  *}>

    <div class='row' >
	<div class='col-12 text-center'>
		<iframe allowfullscreen="" allowtransparency="false" bgcolor="#220000" height="536" scrolling="no"
		src="./play_scratch.php?asfsn=<{$asfsn}>"	 width="725">
	     </iframe>
		 <p> <a href='<{$file}>' target='_blank'>下載</a></p>
		 <{$all.memo}>
	</div>
	</div>
 	<{/if}>


<{*  ---------------------------------------------------------------------------------------------------------------------------   *}>
	<{if $file_mode=='scratchWeb'}>
	<{*  scrtach web  *}>
	<div class='row' >
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
	</div>
	<{/if}>



<{*  ---------------------------------------------------------------------------------------------------------------------------   *}>
	<{if $file_mode=='flash'}>
	<{*  flash *}>
	<div class='row' id ="w">
	<div   class='col-12 text-center'>

		<div id="flashContentdoc" >
		<a href='<{$file}>'>作品下載</a><br />
		使用說明：<br />
		<{$all.memo}>
	</div>
		  <div class='col-12  text-center'>

				<div id="flashContent" > <br>  如未出現 Flash 畫面 <br> 請點選此處並允許執行 Flash <br> <img src="./images/flash_start.png">  <br>
				</div>
	 				<script type="text/javascript" src="swfobject.js"></script>
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
					var params = {
					  bgcolor: "#FFFFFF",
					  allowScriptAccess: "always",
					  allowFullScreen: "true",
					  wmode: "window",
					  menu:"‘false"
					};
					var attributes = {};
					swfobject.embedSWF("<{$file}>", "flashContent", "512", "387", "10.2.0","images/expressInstall.swf",  params, attributes);
					</script>

		</div>

		</div>
	</div>
	<{/if}>


<{*  ---------------------------------------------------------------------------------------------------------------------------   *}>
	<{if $file_mode=='pdf'}>
 	<{*  pdf *}>
	<div class='row' id ="w">
 	<div class='col-12 text-center'>
 		<div id="pdfContent" ><a href="<{$file}>" target="_blank">下載檔案</a>.</p> <p> <{  $all.memo}></p></div>
		<div class="embed-responsive embed-responsive-16by9">
	       <object class="embed-responsive-item" data="<{$file}>" type="application/pdf" internalinstanceid="9" title="">
	           <p>Your browser isn't supporting embedded pdf files. You can download the file
	               <a href="<{$file}>">here</a>.</p>
	       </object>
	    </div>

 		</div>
	</div>
 	<{/if}>
