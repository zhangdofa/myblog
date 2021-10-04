@extends('layouts.home')
@section('content')
    <div class="right">
        <div class="content">
   <form action="{{ route('index.update') }}" method="post" accept-charset="utf-8"> 
    @csrf
    <div class="substance1">
      <h3>修改文章</h3>
      <div class="describe">
      <input type="text" name="id" class="id" value="{{ $data['id'] }}">
      <div class="title3">请输入标题:<input type="text" name="title" value="{{ $data['title'] }}"></div>
      <div class="error">{{ $errors->first('title') }}</div>
      <div class="title3">请输入描述:<input type="text" name="description" value="{{ $data['description'] }}"></div>
      <div class="error">{{ $errors->first('description') }}</div>
      <textarea type="text" name="content" id="EditorId" placeholder="请输入内容">{{ $data['content'] }}</textarea> 
      <div class="error">{{ $errors->first('description') }}</div>
      <input type="submit" value="提交" class="query"> 
    </div>
</div>
   </form> 
    <!-- 配置文件 -->
    <script type="text/javascript" src="{{ asset('ueditor/ueditor.config.js')}}"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="{{ asset('ueditor/ueditor.all.js')}}"></script>
    <!-- 实例化编辑器 -->
  <script type="text/javascript" charset="utf-8">//初始化编辑器 
  window.UEDITOR_HOME_URL = "__PUBLIC__/ueditor/";//配置路径设定为UEditor所放的位置 
  window.onload=function(){ 
    window.UEDITOR_CONFIG.initialFrameHeight=1100;//编辑器的高度 
    window.UEDITOR_CONFIG.initialFrameWidth='100%';//编辑器的宽度 
    var editor = new UE.ui.Editor({ 
      imageUrl : '', 
      fileUrl : '', 
      imagePath : '', 
      filePath : '', 
      imageManagerUrl:'', //图片在线管理的处理地址 
      imageManagerPath:'__ROOT__/' 
    }); 
    editor.render("EditorId");//此处的EditorId与<textarea name="content" id="EditorId">的id值对应 </textarea> 
  } 
</script> 
        </div>
    </div>
@endsection
