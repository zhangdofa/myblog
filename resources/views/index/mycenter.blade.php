@extends('layouts.home')

@section('content')
	<div class="right">
		<div class="mycenter">
	      <h3>个人中心</h3>
	    </div>
		<table class="table table-bordered">
			<thead>
				<tr>
					
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>昵称</td>
					<td>{{ $data->name }}</td>
				</tr>
				<tr>
					<td>邮箱</td>
					<td>{{ $data->email }}</td>
				</tr>
				<tr>
					<td>头像</td>
					<td> 
						<form action="{{ route('index.uploadimg') }}" class="form-horizontal form-bordered" method="post" enctype="multipart/form-data">
						@csrf
						<input type="file" name="title_img" class="default" onchange="changepic(this)"><br>
						<div class="showimg">
							<img src="{{ asset($data->avatars) }}" id="show" width="200"><br>
						</div>
						 <input type="submit" id="file" name="contents" value="上传" /><span class="hint">				*图片类型仅支持 jpeg、jpg、gif、gpeg、png</span>
						</form>
					</td>
				</tr>
			</tbody>
		</table>
		<script>
   function changepic(obj) {
        //console.log(obj.files[0]);//这里可以获取上传文件的name
        var newsrc=getObjectURL(obj.files[0]);
        document.getElementById('show').src=newsrc;
    }

    //建立一個可存取到該file的url
    function getObjectURL(file) {
        var url = null ;
        // 下面函数执行的效果是一样的，只是需要针对不同的浏览器执行不同的 js 函数而已
        if (window.createObjectURL!=undefined) { // basic
            url = window.createObjectURL(file) ;
        } else if (window.URL!=undefined) { // mozilla(firefox)
            url = window.URL.createObjectURL(file) ;
        } else if (window.webkitURL!=undefined) { // webkit or chrome
            url = window.webkitURL.createObjectURL(file) ;
        }
        return url ;
    }
</script>
	</div>
@endsection