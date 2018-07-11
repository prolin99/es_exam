<{$toolbar}>

<{if $now_op=="list_tad_assignment_menu"}>
  <h2><{$smarty.const._MD_TADASSIGN_SELECT_ASSN}></h2>
  <{if $all}>

  <form class="form-horizontal" action="index.php" method="post" id="myForm" enctype="multipart/form-data" onsubmit="return check_1() ;">
      <div class="form-group">
          <label for="assn" class="col-xs-2 control-label">主題</label>
          <div class="col-xs-6">
          <select   id="assn"  name="assn"  class="form-control" >
            <option value=''><{$smarty.const._MD_TADASSIGN_SELECT_ASSN}></option>
            <{foreach from=$all item=data}>
              <option value='<{$data.assn}>' <{if $assn==$data.assn}>selected<{/if}>><{$class_list_c[$data.class_id]}>  -- <{$data.title}> (<{$data.uid_name}>) </option>
            <{/foreach}>
          </select>
            </div>
      </div>
      <div class="form-group">
        <label for="sit_id" class="col-xs-2 control-label">你的座號</label>
        <div class="col-xs-4">
          <input  type="text"  id="sit_id"  class="form-control" name="sit_id"   placeholder="你的座號">
        </div>
      </div>
      <div class="form-group">
        <label for="passwd" class="col-xs-2 control-label">上傳密碼：</label>
        <div class="col-xs-4">
           <input  type="password"  id="passwd" class="form-control"  name="passwd"   placeholder="這次作業的登入密碼">
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-offset-2 col-xs-4">
            <input type="hidden" name="op" value="login_es_exam">
            <button type="submit" class="btn btn-primary" >登入</button>
        </div>
      </div>
   </form>


	<script>
	function check_1() {
		//alert ($("#assn").val() ) ;
		if (  $("#assn").val()==0 ) {
			alert ('需要選擇作業主題！')　;
			return false ;
		}

		var re = /^[0-9]+$/;
		if ( !re.test($("#sit_id").val())  ) {
			alert ('輸入座號有問題！')　;
			return false ;
		}

		if (  $("#passwd").val()==""  ) {
			alert ('沒有輸入密碼！')　;
			return false ;
		}
　
	}
	</script>
  <{elseif $isAdmin}>
    <div class="hero-unit">
      <{$smarty.const._MD_TADASSIGN_EMPTY}>
      <a href="admin/add.php" class="btn btn-info"><{$smarty.const._TAD_ADD}></a>
    </div>
  <{else}>
    <div class="hero-unit">
      <{$smarty.const._MD_TADASSIGN_EMPTY}>
    </div>
  <{/if}>
<{elseif $now_op=="tad_assignment_file_form"}>
  <{*             上傳畫面                                    *}>
  <form action="index.php" method="post" id="myForm" enctype="multipart/form-data">
    <h2><{$title}></h2>
    <div class="alert alert-info"><{$note}></div>
    <table class="table table-striped table-bordered table-hover">
      <tr>
        <th>你的姓名</th>
        <td><h3><span class="col-md-6"><{$class_list_c[$class_id]}> <{$sit_id}> 號 <{$stud_data.name}> </h3></span><span class='col-md-1' ></span>
          <a href="index.php?assn=<{$assn}>" class="btn btn-danger">姓名如果不正確，重新登入</a>
         </td>
      </tr>
      <{if ($no_file==0) }>
      <tr>
        <th><{$smarty.const._MD_TADASSIGN_FILE}> </th>
        <td><input  id="file" name="file"    type="file" size=40  <{$accept_filestr}>  ><p>上傳的副檔名限制：<{$ext_file}></p></td>
      </tr>
      <tr>
        <th>檔案說明</th>
        <td><textarea name="desc"  class="form-control" rows=4 placeholder="作業內容說明，可省略"><{$desc}></textarea></td>
      </tr>
      <{else}>
      <tr>
        <th>輸入文字處</th>
        <td><textarea name="desc"  class="form-control" rows=4 placeholder="作業內容說明"><{$desc}></textarea></td>
      </tr>
      <{/if}>

      <tr>
        <th> </th>
        <td>
           <input type="hidden" name="assn" value="<{$assn}>">
          <input type="hidden" name="op" value="insert_tad_assignment_file">
          <input type="hidden" name="passwd" value="<{$passwd}>">
          <input type="hidden" name="class_id" value="<{$class_id}>">
          <input type="hidden" name="sit_id" value="<{$sit_id}>">
          <input type="hidden" name="author" value="<{$stud_data.name}>">
          <input type="hidden" name="stud_id" value="<{$stud_data.stud_id}>">
          <button type="submit"  class="btn btn-primary"  onclick="return check_2() ;" ><{$smarty.const._MD_SAVE}></button>（上傳後記得再檢查展示作品是否正確！）
        </td>
      </tr>
    </table>
  </form>
	<script>
	function check_2() {
		var fn = ($("#file").val() ) ;

		if (  $("#file").val()=="" ) {
			alert ('你還沒有選擇要上傳的檔案！')　;
			return false ;
		}　

    if (getFileExtension(fn)=="") {
			alert ('要上傳的檔案沒有副檔名，請先另存檔名後再重新上傳！')　;
			return false ;
		}
		<{if ($j_ext_file) }>
			//允許的圖片副檔名
			var re = /\.(<{$j_ext_file}>)$/i;
			if (!re.test(fn) ) {
			 	alert ('只允許上傳檔案的副檔名：<{$ext_file}>！')　;
			 	return false ;
			}
		<{/if}>
　
	}

  //取得副檔名
  function getFileExtension(filename) {
    return filename.slice((filename.lastIndexOf(".") - 1 >>> 0) + 2);
  }
	</script>
<{/if}>
