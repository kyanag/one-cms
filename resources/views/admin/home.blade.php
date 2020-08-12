@extends('admin::layouts.main')

@section('title', '仪表板')

@section('main')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h4">控制台</h1>
        {{--        <div class="btn-toolbar mb-2 mb-md-0">--}}
        {{--            <div class="btn-group mr-2">--}}
        {{--                <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>--}}
        {{--                <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>--}}
        {{--            </div>--}}
        {{--            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">--}}
        {{--                <span data-feather="calendar"></span>--}}
        {{--                This week--}}
        {{--            </button>--}}
        {{--        </div>--}}
    </div>
    @component("admin::components.flash")@endcomponent
    {{--    <h2>Section title</h2>--}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-md">
                <div class="card card-default">
                    <div class="card-header"><i class="fa fa-user"></i> 会员</div>
                    <div class="card-body row">
                        <div class="col-md">
                            <h3>102411</h3>
                            <p>总数</p>
                        </div>
                        <div class="col-md">
                            <h3>30</h3>
                            <p>月增</p>
                        </div>
                        <div class="col-md">
                            <h3>5</h3>
                            <p>日增</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md">
                <div class="card card-default">
                    <div class="card-header"><i class="fa fa-file-invoice"></i> 订单</div>
                    <div class="card-body row">
                        <div class="col-md">
                            <h3>102411</h3>
                            <p>销售</p>
                        </div>
                        <div class="col-md">
                            <h3>30</h3>
                            <p>充值</p>
                        </div>
                        <div class="col-md">
                            <h3>5</h3>
                            <p>日增</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md">
                <div class="card card-default">
                    <div class="card-header"><i class="fa fa-money-bill"></i> 金额</div>
                    <div class="card-body row">
                        <div class="col-md ">
                            <h3>102411</h3>
                            <p>总数</p>
                        </div>
                        <div class="col-md">
                            <h3>30</h3>
                            <p>月增</p>
                        </div>
                        <div class="col-md">
                            <h3>5</h3>
                            <p>日增</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection