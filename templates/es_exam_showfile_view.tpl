
<!-- bootstrap4 -->
<link href="<{$xoops_url}>/modules/tadtools/bootstrap4/css/bootstrap.css" rel="stylesheet" media="all">
<!-- SmartMenus jQuery Bootstrap Addon CSS -->
<link href="<{$xoops_url}>/modules/tadtools/smartmenus/addons/bootstrap-4/jquery.smartmenus.bootstrap-4.css" media="all" rel="stylesheet">
<!-- font-awesome -->
<link href="<{$xoops_url}>/modules/tadtools/css/font-awesome/css/font-awesome.css" rel="stylesheet" media="all">






<div class='row'>


	<{if $file_mode=='picture'}>
	<{*  圖檔 *}>
	<div class='col-12 text-center'> <img class='img-fluid' src='<{$file}>'></div><div><{  $all.memo}></div>
	<{/if}>

	<{if $file_mode=='youtube'}>
	<{*  youtube  *}>
	<div class='col-12 text-center'>
 		<iframe width="560" height="315" src="https://www.youtube.com/embed/<{$all.project_id}>"
 			frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
 		</iframe>
		<p><{$all.memo}></p>
	</div>
	<{/if}>

	<{if $file_mode=='scratch3'}>
	<{*  scrtach3  *}>
	<div id="w">
	<canvas id="s"></canvas>
	<div id="m"></div>
	<div id="b">
	<label id="q" for="a">Question</label>
	<input type="text" id="a">
	</div>
	</div>







	<span id="l">...</span>


	<button id="f"></button>

	<script src="./js/vm.min.js"></script>
	<script src="./js/sb3.js"></script>
	<script type="text/javascript" id="j">

	var
	DESIRED_USERNAME = "griffpatch",COMPAT = true, TURBO = false;
	</script>
	<script src="./js/play_scratch.js"></script>
 	<{/if}>


	<{if $file_mode=='scratch'}>
	<{*  scratch *}>
	<div   class='col-12 text-center'>

		<div id="flashContentdoc" >

		Scratch 一套使用拖拉拼湊就可以寫程式的工具，很好玩的程式軟體。<a href='https://scratch.mit.edu/' target='_blank'>官方網站</a><br /><br />
		<a href='<{$file}>'>作品下載</a><br />


		<{ if $sb2js_mode }>
				<canvas id='scratch' width='486' height='391' tabindex='1'></canvas>
		<{else}>
		  <div class='col-12  text-center'>

			<div class='col-12  text-center' id="flashContent" > <br>  如未出現 Scratch 畫面 <br> 請點選此處並允許執行 Flash <br> <img src="./images/flash_start.png"> <br>
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

				var flashvars = {
				  project: "<{$file}>" ,
				  autostart: "false"
				};

				var params = {
				  bgcolor: "#FFFFFF",
				  allowScriptAccess: "always",
				  allowFullScreen: "true",
				  wmode: "window",
				  menu:"‘false"
				};
				var attributes = {};
				swfobject.embedSWF("images/Scratch.swf", "flashContent", "512", "387", "11.7.0","images/expressInstall.swf", flashvars, params, attributes);
				</script>
			</div>
			<div class='col-12  text-center'>
				使用說明：<br />
				<{$all.memo}>
			</div>

		<{/if}>
		</div>

	</div>



	<{/if}>

	<{if $file_mode=='flash'}>
	<{*  flash *}>
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

	<{if $file_mode=='pdf'}>
 	<{*  pdf *}>

 	<div class='col-12 text-center'>
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
