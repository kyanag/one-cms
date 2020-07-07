@extends('admin::layouts.main')

@section('title', '仪表板')

@section('main')
    <div id="main">
        <div id="ribbon">
            @include("admin::components.breadcrumb")
        </div>
        <div id="content">
            <div class="content-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="panel panel-default">
                                <div class="panel-heading"><i class="fa fa-user"></i> 会员</div>
                                <div class="panel-body">
                                    <div class="col-md-4">
                                        <h3>102411</h3>
                                        <p>总数</p>
                                    </div>
                                    <div class="col-md-4">
                                        <h3>30</h3>
                                        <p>月增</p>
                                    </div>
                                    <div class="col-md-4">
                                        <h3>5</h3>
                                        <p>日增</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="panel panel-default">
                                <div class="panel-heading"><i class="fa fa-files-o"></i> 订单</div>
                                <div class="panel-body">
                                    <div class="col-md-4">
                                        <h3>102411</h3>
                                        <p>销售</p>
                                    </div>
                                    <div class="col-md-4">
                                        <h3>30</h3>
                                        <p>充值</p>
                                    </div>
                                    <div class="col-md-4">
                                        <h3>5</h3>
                                        <p>日增</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="panel panel-default">
                                <div class="panel-heading"><i class="fa fa-jpy"></i> 金额</div>
                                <div class="panel-body">
                                    <div class="col-md-4">
                                        <h3>102411</h3>
                                        <p>总数</p>
                                    </div>
                                    <div class="col-md-4">
                                        <h3>30</h3>
                                        <p>月增</p>
                                    </div>
                                    <div class="col-md-4">
                                        <h3>5</h3>
                                        <p>日增</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <script>

            </script>
        </div>
    </div>
    <script>

    </script>
@endsection