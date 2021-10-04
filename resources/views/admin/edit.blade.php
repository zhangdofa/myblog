@extends('layouts.admin')
@section('content')
@parent
    <div class="right">
        <div class="content">
          <form action="{{ route('admin.update') }}" method="post" accept-charset="utf-8"> 
          @csrf
          <div class="substance1">
            <h3 class="headline">修改文章</h3>
            <div class="describe">
              <input type="text" name="id" class="id" value="{{ $data['id'] }}">
              <div class="title3">请输入标题:<input type="text" name="title" value="{{ $data['title'] }}"></div>
              <div>{{ $errors->first('title') }}</div>
              <div class="title3">请输入描述:<input type="text" name="description" value="{{ $data['description'] }}"></div>
              <div>{{ $errors->first('description') }}</div>
              <div id="div1">{!! $data['content'] !!}</div>
              <textarea id="text1" type="text" name="content" style="display: none;"></textarea>
              <div>{{ $errors->first('description') }}</div>
              <input type="submit" value="提交" class="query"> 
            </div>
        </div>
        </form> 
        </div>
    <!-- 注意， 只需要引用 JS，无需引用任何 CSS ！！！-->
    <script type="text/javascript" src="{{ asset('/js/wangEditor.min.js') }}"></script>
    <script type="text/javascript">
        var E = window.wangEditor
        var editor = new E('#div1')
        var $text1 = $('#text1')
        editor.customConfig.onchange = function (html) {
            // 监控变化，同步更新到 textarea
            $text1.val(html)
        }
        editor.create()
        // 初始化 textarea 的值
        $text1.val(editor.txt.html())
    </script>
    </div>
@endsection
