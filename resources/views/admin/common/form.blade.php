@extends('admin::layouts.main')

@section('title', $title)

@section('main')
    <div id="main">
        <div id="ribbon"><ol class="breadcrumb"></ol></div>
        <div id="content">
            @component("admin::components.flash")@endcomponent

            <div class="content-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading"><i class="fa fa-fw {{ $_icon }}"></i> {{ $title }}</div>
                                <div class="panel-body">
                                    {!! $form->render() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

    </script>
@endsection