@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('订单列表') }}
                    @if ($type == 1)
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        导入
                    </button>
                    @endif
                    @if ($type == 2)
                    <a class="btn btn-primary" href="{{ route('order.loading') }}">同步订单</a>
                    @endif
                    <a class="btn btn-primary" href="{{ route('order.export', [$type, 1]) }}">导出全部</a>
                    <a class="btn btn-primary" href="{{ route('order.export', [$type, 2]) }}">导出异常订单</a>
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('order.import') }}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                        <div class="form-group">
                                            <label for="file">文件</label>
                                            <input type="file" name="file" class="form-control-file" id="file">
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                                    <button type="submit" class="btn btn-primary">提交</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table">
                        <caption></caption>
                        <thead>
                        <tr>
                            <th scope="col" width="10%">快递公司</th>
                            <th scope="col" width="10%">单号</th>
                            <th scope="col" width="5%">平台</th>
                            <th scope="col" width="8%">状态</th>
                            <th scope="col">物流信息</th>
                            <th scope="col">备注信息</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->company }}</td>
                            <td>{{ $order->number }}</td>
                            <td>{{ $order->platform }}</td>
                            <td>{{ $order->status }}</td>
                            <td>
                                @if ($order->detail)
                                @foreach (json_decode($order->detail) as $item)
                                   {{ $item->time }} <br>
                                   {{ $item->status }} <br>
                                @endforeach
                                @endif
                            </td>
                            <td>{{ $order->remark }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                       总计 : {{ $total }} 条
                    </table>
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
