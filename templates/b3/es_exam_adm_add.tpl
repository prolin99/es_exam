<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/My97DatePicker/WdatePicker.js"></script>
<form action="add.php"  method="post" id="myForm" name="myForm" enctype="multipart/form-data" class="form-inline">

<link href="../css/bootstrap-switch.css" rel="stylesheet">
<script src="../js/bootstrap-switch.js"></script>


<{if (!$assn)}>
  <div class="row">
    <div class="col-md-2 ">選擇班級(可多選)</div>
    <div class="col-md-8  "><{html_options  multiple="multiple"   class="form-control" size="8"  name="class_id[]" options=$class_list_c      }></div>
  </div>
<{else}>
  <div class="row">
    <div class="col-md-2  ">班級</div>
    <div class="col-md-8  "><{$class_id}></div>
  </div>
<{/if}>

  <div class="row">
    <div class="col-md-2  "><{$smarty.const._MA_TADASSIGN_TITLE}></div>
    <div class="col-md-8  "><input type="text" name="title" value="<{$title}>" class="form-control"  placeholder="<{$smarty.const._MA_TADASSIGN_TITLE}>" ></div>

  </div>

  <div class="row">
    <div class="col-md-2  "><{$smarty.const._MA_TADASSIGN_PASSWD}></div>
    <div class="col-md-3"><input type="text" name="passwd" class="form-control" value="<{$passwd}>" placeholder="<{$smarty.const._MA_TADASSIGN_PASSWD}>"></div>
    <div class="col-md-5 "><{$smarty.const._MA_TADASSIGN_PASSWD_DESC}></div>
  </div>

  <div class="row">
    <div class="col-md-2  ">限制上傳的副檔名</div>
    <div class="col-md-3 "><input type="text" name="ext_file" class="form-control" value="<{$ext_file}>" placeholder="例： jpg,jpeg,png "></div>
    <div class="col-md-5 ">(逗號分隔多種副檔名，依此類別做線上展示（PDF,scratch...)，空白表示不限制。)</div>
  </div>


  <div class="row">
    <div class="col-md-2 "><{$smarty.const._MA_TADASSIGN_NOTE}></div>
    <div class="col-md-8 "><textarea name="note"  class="form-control" rows=4 cols=60 placeholder="<{$smarty.const._MA_TADASSIGN_NOTE}>"><{$note}></textarea></div>
  </div>

  <div class="row">
    <div class="col-md-2 ">學生上傳作業</div>
    <div class="col-md-8 ">
        <div class="col-md-2  ">
        <input type="checkbox" name="upload_mode"  class="upload" value=1  <{if $upload_mode=='1'}>checked<{/if}>  id="upload_mode">
        </div>
        <div class="col-md-8 ">(不上傳，用於外部作品或上課表現評分)</div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-2">只傳網址</div>
    <div class="col-md-8 ">
    <div class="col-md-2">
        <input type="checkbox" class="form-control" name="upload_url"  class="upload" value=1  <{if $upload_url=='1'}>checked<{/if}>  id="upload_url">
    </div>
    <div class="col-md-6">(不上傳檔案，只貼上網址，可用於 scratch.mit.edu 作品呈現)</div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-2  ">只撰寫文字上傳</div>
    <div class="col-md-8 ">
        <div class="col-md-2  ">
        <input type="checkbox" name="no_file"  class="upload"   value=1  <{if $no_file=='1'}>checked<{/if}>  id="no_file">

      </div>
      <div class="col-md-8 ">(只有文字欄位，無檔案上傳，用於純文字心得寫作。)</div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-2  "><{$smarty.const._MA_TADASSIGN_SHOW}></div>
    <div class="col-md-8  ">
       <div class="col-md-2">
        <input type="checkbox" name="open_show"  class="upload"   value=1  <{if $open_show=='1'}>checked<{/if}>  id="upload_mode">
        </div>
        <div class="col-md-8 ">(開放全部人都可以查看作品)</div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-2  ">評分時，使用雲端觀看。</div>
    <div class="col-md-8 ">
       <div class="col-md-1  ">
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
  $("[name='no_file']").bootstrapSwitch();
  $("[name='upload_url']").bootstrapSwitch();
 </script>
