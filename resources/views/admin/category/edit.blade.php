@extends('admin::layouts.main')

@section('title', $title)

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-default">
                        <div class="card-header"><i class="fa fa-fw fa-cog"></i>操作面板</div>
                        <div class="card-body">
                            <form class="form-inline" role="form" method="get" action="../server/ajaxReturn.json" data-validate="validate1" data-callBack="callback1">
                                <div class="form-group">
                                    <label>新闻分类</label>
                                    <select name="pid" class="form-control">
                                        <option value="0">请选择</option>
                                        <option value="1">行业新闻</option>
                                        <option value="2">企业新闻</option>
                                    </select>
                                </div>
                                <span class="gap"></span>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="audit" value="1"> 是否通过审查
                                    </label>
                                </div>
                                <span class="gap"></span>
                                <button type="button" class="btn btn-primary">查询</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-default">
                        <div class="card-header"><i class="fa fa-fw fa-file-text"></i>表单</div>
                        <div class="card-body">
                            {!! $form->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

    </script>
@endsection