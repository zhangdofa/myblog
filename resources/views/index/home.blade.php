@extends('layouts.home')
@section('content')
<div class="right">
        <div class="content">
            <div class="title">
                <h5>zhangdongfa的个人博客</h5>
                <h6>奋斗令我们的生活充满生机，责任让我们的生命充满意义，常遇困境说明你在进步，常有压力，说明你有目标。</h6>
            </div>
            <div class="substance">
                @foreach ($data as $user)
                <div class="describe">
                    <div class="id">{{ $user->id }}</div>
                    <div class="title5">{{ $user->title }}</div>
                    <div class="title2">{{ $user->description }}</div>
                    <div class="update">  
                        <div class="zan">
                            赞<span> {{ $user->zans_count }}</span>   |
                            评论<span> {{ $user->comments_count }}</span>
                        </div>
                        <div class="uptime">
                            <span>{{ $user->user->name }}</span> 于 <span>{{ $user->created_time }}</span> 上传
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
          
                <div class="next">
                    {{ $data->links() }}
                </div>
        </div>
    </div>
@endsection
