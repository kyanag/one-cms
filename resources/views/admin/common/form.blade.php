<?php
/** @var \Kyanag\Form\Component $form */
?>

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
                {!! $form->render() !!}
            </div>
        </div>
    </div>

    @php
        \App\Supports\Asset::registerJs(<<<EOF
$("#{$form->id}").former();
$("#{$form->id}").ajaxForm({
    success:function(d){
        console.log(d);
        if(d.jump){
            bootbox.alert(d.msg, function(){
                window.location.href = d.jump;
            });
        }
    }
});
EOF
    );
    @endphp
@endsection