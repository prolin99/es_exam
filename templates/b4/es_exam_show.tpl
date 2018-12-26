
<{$toolbar}>


<h2><{$smarty.const._MD_TADASSIGN_SELECT_ASSN}> </h2>

<form class="form-inline" >
  <select  class="form-control " onChange="window.location.href='show.php?assn='+this.value">
    <option value=''><{$smarty.const._MD_TADASSIGN_SELECT_ASSN}></option>
    <{if $select_assn_all}>
      <{foreach from=$select_assn_all item=data}>
        <option value='<{$data.assn}>' <{if $assn==$data.assn}>selected<{/if}>> <{$class_list_c[$data.class_id]}>  -- <{$data.title}> (<{$data.uid_name}>) </option>
      <{/foreach}>
    <{/if}>
  </select>
</form>



  <link rel="stylesheet" href="<{$xoops_url}>/modules/tadtools/fancyBox/source/jquery.fancybox.css" type="text/css" />
  <script src="<{$xoops_url}>/modules/tadtools/fancyBox/lib/jquery.mousewheel.pack.js" type="text/javascript"></script>
  <script src="<{$xoops_url}>/modules/tadtools/fancyBox/source/jquery.fancybox.js" type="text/javascript"></script>

  <link rel="stylesheet" href="css/star-rating.css" media="all" type="text/css"/>
  <script src="js/star-rating.js" type="text/javascript"></script>
  <script src="js/locales/zh.js" type="text/javascript"></script>



<style type="text/css">
  .fancybox-nav {
     width: 10%;
   }
   </style>

  <script type='text/javascript'>
    $(document).ready(function(){
      $(".assignment_fancy_<{$assn}>").fancybox({
      <{if  ($ifram_show) }>
      'type' : 'iframe' ,
      <{/if}>
      fitToView : true,
      width   : '90%',
      height    : '100%',
       autoSize  : true,
      closeClick  : false
      });

    });


    function delete_func(asfsn ,stud_id){
      var sure = window.confirm('<{$smarty.const._TAD_DEL_CONFIRM}>');
      if (!sure)  return;
      location.href="show.php?op=delete_tad_assignment_file&assn=<{$assn}>&asfsn=" + asfsn   + "&stud_id=" + stud_id  ;
    }

  </script>
<{if ($assn) }>
  <div class="row">
    <div class="col-8"><h2><{$class_id}>班   <{$title}></h2></div>
    <div class="col-4 text-right">
       <button class="btn btn-warning" type="button" onClick="window.location.reload()" title='重新載入畫面'>重整</button>
    	<a href="index.php?assn=<{$assn}>" class="btn btn-primary"><{$smarty.const._MD_UPLOAD}></a>
    	<{if $isAdmin}><a href="admin/score.php?assn=<{$assn}>" class="btn btn-success">評分</a><{/if}>

    </div>
  </div>
  <{if (!$open_show) }>
  	<div class="alert alert-info">
  	<strong>注意！</strong>
  	這項主題作業未開放展示，只顯示上傳記錄！
  	</div>
  <{/if}>



  <h5>未繳交作業：</h5>
  <div class="row">
  <{foreach from=$class_students  key=sit item=stud}>
  <{if (!$stud.in)  }>
  <span class="col-2"><span class="badge badge-info"><{ $sit }></span><{if $isAdmin}> <{ $stud.name }><{/if}></span>
  <{/if}>
  <{/foreach}>
  </div>
<div class="table-responsive">
  <table class="table"  >
    <thead>
  <tr class='row' >
  <th scope="col" class='col-2' >
      <{$smarty.const._MD_TADASSIGN_UP_TIME}><a href='show.php?assn=<{$assn}>'><i class="fa fa-sort" aria-hidden="true"></i> </a>

  </th  >
  <th scope="col" class='col-2' >

      <{$smarty.const._MD_TADASSIGN_FILENAME}>

  </th>
  <th  class='col-1'  alt='可依條件排序' title='可依條件排序'>

      座號<a href='show.php?assn=<{$assn}>&order=num_id'><i class="fa fa-sort" aria-hidden="true"></i> </a>

  </th>
  <th  class='col-2' ><{$smarty.const._MD_TADASSIGN_AUTHOR}></th>
  <th  class='col-2' >表現</th>
  <{if $isAdmin}><th  class='col-2'><{$smarty.const._TAD_FUNCTION}></th><{/if}>
</thead>
  </tr  >
  <tbody>
  <{foreach from=$file_data item=all}>

  <{ if ($all.old_file) }>
    <tr class='row table-danger' title='舊檔案'>
  <{else}>
    <tr class='row'>
  <{/if}>
      <td class='col-2' ><{$all.up_time}><br />ip:<{$all.up_ip}></td>
      <td  class='col-2'  style="word-break : break-all; overflow:hidden; " >
      <{if ($open_show)}>
          <{if  ($ifram_show) }>
          	<div  >
          	<a href="show_file.php?assn=<{$all.assn}>&stud_id=<{$all.stud_id}>&asfsn=<{$all.asfsn}>&sub_name=<{$all.sub_name}>&score_bar=<{$all.score_bar}>"  studfile='<{$smarty.const._TAD_ASSIGNMENT_UPLOAD_URL}><{$all.assn}>/<{$all.asfsn}>.<{$all.sub_name}>'  class="assignment_fancy_<{$assn}>" rel="group" title="<{$all.sit_id}>.<{$all.author}> (<{$all.up_time}>) <{$all.file_name}>"  target="show"><{$all.file_name |truncate 20}></a>
          	</div>
          	<div ><{  $all.memo}></div>
         <{else}>

         	 <a href='<{$smarty.const._TAD_ASSIGNMENT_UPLOAD_URL}><{$all.assn}>/<{$all.asfsn}>.<{$all.sub_name}>'  class="assignment_fancy_<{$assn}>" rel="group" title="<{$all.sit_id}>.<{$all.author}> (<{$all.up_time}>) <{$all.file_name}>"><{$all.file_name|truncate 20}></a>

          	<div ><{  $all.memo }></div>
         <{/if}>  <{*   / $ifram_show *}>
      <{else}>
      	<span >
 		    <{$all.file_name|truncate 20}>
 	      </span>
      <{/if}> <{*   / $open_show *}>
      </td>
      <td   class='col-1'> <{$all.sit_id}></td>
      <td  class='col-2' > <{$all.author}></td>
      <td  class='col-2' >
      <{if ($all.score) }>
      <div class="row">
       <input  type="text"   readonly class="rating" value="<{$all.score_star}>"   data-min=0 data-max=5 data-step=0.5 data-size="xs" title=""     >

		<div class='col-4'><{  $all.comment}></div>
       </div>
	  <{/if}>	 <{*   / $score *}>
	</td>
      <{if $isAdmin}>
      <td class='col-2'>
        <a href="javascript:delete_func(<{$all.asfsn}>,<{$all.stud_id}>);" class="btn btn-mini btn-danger"><{$smarty.const._TAD_DEL}></a>
      </td>
      <{/if}>  <{*   / $isAdmin *}>
    </tr>

  <{/foreach}>
  </tbody>
  </table>
</div>

<{/if}>
