@extends('layouts.admin')

@section('content')
@if (isset($data))
    <div class="right">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom" style="padding-top: 10px;">
            <h4>文章</h4>
            <form class="form-inline" action="{{ route('admin.find') }}" method="get">
                @csrf

                <label class="sr-only col-form-label-sm" for="title">标题</label>
                <input type="text" class="form-control form-control-sm mb-2 mr-sm-2" id="title" name="title" value=""
                       placeholder="标题">

                <div class="form-check mb-2 mr-sm-2">
                    <label class="form-check-label" for="is_top">
                    </label>
                </div>

                <button type="submit" class="btn btn-sm btn-primary mb-2">查找</button>
            </form>

            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                    <!-- <a class="btn btn-sm btn-outline-secondary" href="">创作</a> -->
                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.index') }}">列表</a>
                    {{--<button class="btn btn-sm btn-outline-secondary">Share</button>--}}
                    {{--<button class="btn btn-sm btn-outline-secondary">Export</button>--}}
                </div>
                {{--<button class="btn btn-sm btn-outline-secondary dropdown-toggle">--}}
                {{--<span data-feather="calendar"></span>--}}
                {{--This week--}}
                {{--</button>--}}
            </div>
        </div>


        {{--<canvas class="my-4" id="myChart" width="900" height="380"></canvas>--}}
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>#</th>
                    <th>标题</th>
                    <th>发布者</th>
                    <th>时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $i => $article)
                    <tr>
                        @if ($data->currentPage() === 1)
                            <td>{{ $i+1 }}</td>
                        @else
                            <td>{{ ($data->currentPage()-1)*$data->perPage()+$i+1 }}</td>
                        @endif
                        <td class="text-nowrap overflow-slh">{{ $article['title'] }}</td>
                        <td>{{ $article->user->name }}</td>
                        <td>{{ $article['updated_time'] }}</td>
                        <td>
                            <a href="{{ route('admin.edit', ['id'=>$article['id']]) }}"
                               class="btn btn-sm btn-outline-secondary py-0 pr-1 pl-1">编辑</a>
                          
                            <a href=""
                               class="btn btn-sm btn-outline-secondary py-0 pr-1 pl-1"
                               onclick="event.preventDefault();document.getElementById('delete-form-{{$article['id']}}').submit();">
                                {{ __('删除') }}
                            </a>

                            <form id="top-form-{{$article['id']}}" action=""
                                  method="POST" style="display: none;">
                                @csrf
                                <input type="hidden" name="id" value="{{ $article['id'] }}">
                            </form>

                            <form id="delete-form-{{$article['id']}}" action="{{ route('admin.delete') }}"
                                  method="POST" style="display: none;">
                                @csrf
                                <input type="hidden" name="id" value="{{ $article['id'] }}">
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="next">
                    {{ $data->links() }}
        </div>
    </div>


@else
    <div class="right">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom" style="padding-top: 10px;">
            <h4>文章</h4>
            <form class="form-inline" action="{{ route('admin.find') }}" method="get">
                @csrf
            
                <label class="sr-only col-form-label-sm" for="title">标题</label>
                <input type="text" class="form-control form-control-sm mb-2 mr-sm-2" id="title" name="title" value=""
                       placeholder="标题">

                <div class="form-check mb-2 mr-sm-2">
                    <label class="form-check-label" for="is_top">
                    </label>
                </div>

                <button type="submit" class="btn btn-sm btn-primary mb-2">查找</button>
            </form>

            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                    <!-- <a class="btn btn-sm btn-outline-secondary" href="">创作</a> -->
                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.index') }}">列表</a>
                    {{--<button class="btn btn-sm btn-outline-secondary">Share</button>--}}
                    {{--<button class="btn btn-sm btn-outline-secondary">Export</button>--}}
                </div>
                {{--<button class="btn btn-sm btn-outline-secondary dropdown-toggle">--}}
                {{--<span data-feather="calendar"></span>--}}
                {{--This week--}}
                {{--</button>--}}
            </div>
        </div>


        {{--<canvas class="my-4" id="myChart" width="900" height="380"></canvas>--}}
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>#</th>
                    {{--<th>Slug</th>--}}
                    <th>标题</th>
                    <!-- <th>分类</th>
                    <th>阅读</th> -->
                    <th>发布者</th>
                    <th>时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data1 as $i => $article)
                    <tr>
                        @if ($data1->currentPage() === 1)
                            <td>{{ $i+1 }}</td>
                        @else
                            <td>{{ ($data1->currentPage()-1)*$data1->perPage()+$i+1 }}</td>
                        @endif
                        <td class="text-nowrap overflow-slh">{{ $article['title'] }}</td>
                        <td>{{ $article->user->name }}</td>
                        <td>{{ $article['updated_time'] }}</td>
                        <td>
                            <a href="{{ route('admin.edit', ['id'=>$article['id']]) }}"
                               class="btn btn-sm btn-outline-secondary py-0 pr-1 pl-1">编辑</a>
                          
                            <a href=""
                               class="btn btn-sm btn-outline-secondary py-0 pr-1 pl-1"
                               onclick="event.preventDefault();document.getElementById('delete-form-{{$article['id']}}').submit();">
                                {{ __('删除') }}
                            </a>

                            <form id="top-form-{{$article['id']}}" action=""
                                  method="POST" style="display: none;">
                                @csrf
                                <input type="hidden" name="id" value="{{ $article['id'] }}">
                            </form>

                            <form id="delete-form-{{$article['id']}}" action="{{ route('admin.delete') }}"
                                  method="POST" style="display: none;">
                                @csrf
                                <input type="hidden" name="id" value="{{ $article['id'] }}">
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="next">
                    {!! $data1->appends(['title' => $find])->links() !!}
        </div>
    </div>
@endif

@endsection
