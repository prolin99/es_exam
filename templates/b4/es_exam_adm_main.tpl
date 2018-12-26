
<link href="../css/bootstrap-switch.css" rel="stylesheet">
<script src="../js/bootstrap-switch.js"></script>
<div class="container-fluid">
<h2><{$smarty.const._MA_TADASSIGN_ASSN_LIST}></h2>

<script>
function delete_tad_assignment_func(assn){
  var sure = window.confirm("<{$smarty.const._TAD_DEL_CONFIRM}>");
  if (!sure)  return;
  location.href="main.php?op=delete_tad_assignment&assn=" + assn;
}
</script>





<table  class="table table-striped" >
<tr class='row'>
 <th class="col-1">班級</th>
  <th class="col-1"><{$smarty.const._MA_TADASSIGN_ASSN}>-<{$smarty.const._MA_TADASSIGN_TITLE}></th>
  <th class="col-1"><{$smarty.const._MA_TADASSIGN_PASSWD}></th>
  <th class="col-1"><{$smarty.const._MA_TADASSIGN_UID}></th>
  <th class="col-1">是否上傳</th>
  <th class="col-1"><{$smarty.const._MA_TADASSIGN_SHOW}></th>
  <th class="col-1">google觀看</th>
  <th class="col-3"><{$smarty.const._TAD_FUNCTION}></th>
</tr>
<tbody>

<{foreach from=$all_data item=as}>
  <{if ($as.is_own) }>
  <tr class='row' >
 <{else}>
 <tr class="row table-warning">
 <{/if}>
    <td class="col-1"><{$class_list_c[$as.class_id]}></td>

    <td  class="col-1"><{$as.assn}> - <a href="../show.php?assn=<{$as.assn}>"><{$as.title}></a></td>
    <td class="col-1">
        <input id="pwd_<{$as.assn}>" class="form-control  pwd"  value="<{$as.passwd}>" title="可以直接修改">
    </td>
    <td class="col-1"><{$as.uid_name}></td>

    <td class="col-1">


        <input type="checkbox" name="my-checkbox"  class="upload" <{if $as.upload_mode=='1'}>checked<{/if}>  id="upload_<{$as.assn}>">

    </td>

    <td class="col-1">

        <input type="checkbox" name="my-checkbox"  class="open_show" <{if $as.open_show=='1'}>checked<{/if}>  id="openshow_<{$as.assn}>">


    </td>
    <td class=" col-1">
         <input type="checkbox" name="my-checkbox"  class="gview_mode" <{if $as.gview_mode=='1'}>checked<{/if}>  id="gviewmode_<{$as.assn}>">
    </td>

    <td class="col-3">
      <a href="javascript:delete_tad_assignment_func(<{$as.assn}>);" class="btn btn-mono btn-danger"><{$smarty.const._TAD_DEL}></a>
      <a href="add.php?op=tad_assignment_form&assn=<{$as.assn}>" class="btn btn-mono btn-warning"><{$smarty.const._TAD_EDIT}></a>
      <a href="score.php?op=score&assn=<{$as.assn}>" class="btn btn-mono btn-success">評分</a>
    </td>
  </tr>
<{/foreach}>

</tbody>

</table>

    <div class='row'>
         <div class="col-8 offset-4"><{$bar}></div>
    </div>
</div>

<script type="text/javascript">
 $("[name='my-checkbox']").bootstrapSwitch();

//上傳 展示 切換  http://www.bootstrap-switch.org/
$('input[name="my-checkbox"]').on('switchChange.bootstrapSwitch', function(event, state) {

    var tid = $( this).attr('id') ;
    /*
    //alert (tid + state) ;
    console.log(tid); // DOM element
    console.log(this); // DOM element
    console.log(event); // jQuery event
    console.log(state); // true | false
    */
    setdata( 'upload' ,tid , state ) ;
});

//密碼更改
$(function() {

	$(".pwd").change(function(){
		var tid = $( this ).attr('id') ;
		var pwd = $( this ).val();
 		setdata( 'pwd' ,tid , pwd ) ;
	});
});




$(function() {
	$(".pwd").focus(function(){
		  $( this ).select() ;
	});
});

 function setdata(do_mode ,tid , sdata )  {

 	var splits = tid.split('_') ;
      var id_mod = splits[0] ;
 	var iid= splits[1] ;
 	//alert (sdata) ;
 	$.ajax({
 		url: 'ajax_set_exam_data.php',
 		type: 'GET',
 		data: {do: do_mode , id:iid , id_mode: id_mod  , setdata :sdata   },
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

</script>
