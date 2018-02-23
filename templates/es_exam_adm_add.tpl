<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/My97DatePicker/WdatePicker.js"></script>
<form action="add.php" class="form-inline" method="post" id="myForm" name="myForm" enctype="multipart/form-data">

<link href="../css/bootstrap-switch.css" rel="stylesheet">
<script src="../js/bootstrap-switch.js"></script>


<{if (!$assn)}>
  <div class="row">
    <div class="col-md-2 col-xs-2">選擇班級(可多選)</div>
    <div class="col-md-8  col-xs-8"><{html_options  multiple="multiple"   class="form-control" size="8" name="class_id[]" options=$class_list_c  class="form-control"   }></div>
  </div>
<{else}>
  <div class="row">
    <div class="col-md-2  col-xs-2">班級</div>
    <div class="col-md-8  col-xs-8"><{$class_id}></div>

  </div>
<{/if}>

  <div class="row">
    <div class="col-md-2  col-xs-2"><{$smarty.const._MA_TADASSIGN_TITLE}></div>
    <div class="col-md-8  col-xs-8"><input type="text" name="title" value="<{$title}>" class="col-md-12 col-xs-12"  placeholder="<{$smarty.const._MA_TADASSIGN_TITLE}>"></div>

  </div>

  <div class="row">
    <div class="col-md-2  col-xs-2"><{$smarty.const._MA_TADASSIGN_PASSWD}></div>
    <div class="col-md-3  col-xs-3"><input type="text" name="passwd" class="col-md-12 col-xs-12" value="<{$passwd}>" placeholder="<{$smarty.const._MA_TADASSIGN_PASSWD}>"></div>
    <div class="col-md-5  col-xs-5"><{$smarty.const._MA_TADASSIGN_PASSWD_DESC}></div>

  </div>

  <div class="row">
    <div class="col-md-2  col-xs-2">限制上傳的副檔名</div>
    <div class="col-md-3  col-xs-3"><input type="text" name="ext_file" class="col-md-12 col-xs-12" value="<{$ext_file}>" placeholder="例： jpg,jpeg,png "></div>
    <div class="col-md-5  col-xs-5">(以逗號分隔多種副檔案，依此做線上展示（PDF,scratch...)，空白表示不限制。)</div>

  </div>


  <div class="row">
    <div class="col-md-2 col-xs-2"><{$smarty.const._MA_TADASSIGN_NOTE}></div>
    <div class="col-md-8 col-xs-8"><textarea name="note"  class="col-md-12  col-xs-12" rows=4 placeholder="<{$smarty.const._MA_TADASSIGN_NOTE}>"><{$note}></textarea></div>
  </div>

  <div class="row">
    <div class="col-md-2 col-xs-2">開放上傳</div>
    <div class="col-md-8 col-xs-8">
        <div class="col-md-2  ">
        <input type="checkbox" name="upload_mode"  class="upload" value=1  <{if $upload_mode=='1'}>checked<{/if}>  id="upload_mode">
        </div>
        <div class="col-md-8 ">(外部作品評分或上課表現評份，可以指定不開放上傳，。)</div>

    </div>
  </div>


  <div class="row">
    <div class="col-md-2  col-xs-2"><{$smarty.const._MA_TADASSIGN_SHOW}></div>
    <div class="col-md-8  col-xs-8">
       <div class="col-md-1 col-xs-2">
        <input type="checkbox" name="open_show"  class="upload"   value=1  <{if $open_show=='1'}>checked<{/if}>  id="upload_mode">
        </div>

    </div>
  </div>

  <div class="row">
    <div class="col-md-2  col-xs-2">評分時，使用雲端觀看。</div>
    <div class="col-md-8 col-xs-8">
       <div class="col-md-1  col-xs-2">
        <input type="checkbox" name="gview_mode"  class="upload"   value=1  <{if $gview_mode=='1'}>checked<{/if}>  id="gview_mode">
        </div>
    </div>
  </div>

  <div style="text-align:center;">
    <input type="hidden" name="op" value="<{$op}>">
    <input type="hidden" name="assn" value="<{$assn}>">
    <button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SAVE}></button>
  </div>
</form>
<script type="text/javascript">
 $("[name='upload_mode']").bootstrapSwitch();
  $("[name='open_show']").bootstrapSwitch();
  $("[name='gview_mode']").bootstrapSwitch();
 </script>
