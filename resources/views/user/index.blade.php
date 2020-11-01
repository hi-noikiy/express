@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('用户列表') }} <a class="btn btn-primary" href="{{ route('user.create_view') }}">新增</a></div>

                <div class="card-body">
                    <table class="table">
                        <caption></caption>
                        <thead>
                        <tr>
                            <th scope="col">用户名</th>
                            <th scope="col">创建时间</th>
                            {{--<th scope="col">状态</th>--}}
                            <th scope="col">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            @foreach ($users as $user)
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at }}</td>
                            {{--<td>@if ($user->status == 1) 启用 @else 禁用 @endif</td>--}}
                            <td>
                                <a href="{{ route('user.delete', ['id' => $user->id]) }}">删除</a>
                                {{--<a href="{{ route('user.enable', ['id' => $user->id]) }}">@if ($user->status == 1) 禁用 @else 启用 @endif</a>--}}
                            </td>
                            @endforeach
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
