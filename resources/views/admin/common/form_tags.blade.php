@extends('admin::layouts.main')

@section('title', $title)

@section('main')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h4">{{ $title }} <small>{{ $description }}</small></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <a class="btn btn-sm btn-outline-primary" href="{{ $urlCreator->index() }}"><i class="fa fa-bars"></i> 列表</a>
                <a class="btn btn-sm btn-outline-primary" href="javascript:history.back()"><i class="fa fa-undo"></i> 返回</a>
            </div>
        </div>
    </div>
    @component("admin::components.flash")@endcomponent
    {{--    <h2>Section title</h2>--}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="http://localhost:8000/admin/category/1" id="OC-form-tags">
                    <div class="nav nav-tabs" role="tablist">
                        <a class="nav-item nav-link active show" href="#tab-main" data-toggle="tab" role="tab" aria-selected="true">主内容</a>
                        <a class="nav-item nav-link" href="#tab-additional" data-toggle="tab" role="tab" aria-selected="true">附加信息</a>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active show" id="tab-main" role="tabpanel">
                            <div class="border border-top-0 mb-3 pt-3 col-md-12">
                                {!! $form->render() !!}
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-additional" role="tabpanel">
                            <div class="border border-top-0 mb-3 pt-3 col-md-12">
                                {!!
                                \App\Admin\Facades\Admin::createElement("selectize", [
                                    'id' => "form-extends",
                                    "name" => "extends",
                                    'label' => "附加表单",
                                    'help' => "选择附加表单， 增加附加内容",
                                    'multiple' => true,
                                    'options' => [
                                        1 => "普通内容",
                                    ],
                                ])->render()
                                !!}
                            </div>
                            <div class="row" id="additional-actives">

                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">确认</button>
                    <button type="reset" class="btn btn-warning">重置</button>
                </form>
            </div>
        </div>
    </div>

    @php
        \App\Supports\Asset::registerJs(<<<EOF
$("#OC-form-tags").former();
$("#OC-form-tags").ajaxForm({
    success: function(data,statusText){
        console.log(data, statusText);
    },
});
$("#form-extends").change(function(){
    console.log($(this).val())
});
EOF
    );
    @endphp
@endsection