@extends('admin::layouts.main')

@section('title', $title)

@section('main')
    <div id="main">
        <div id="ribbon">
            @include("admin::components.breadcrumb")
        </div>
        <div id="content">
            @component("admin::components.flash")@endcomponent

            <div class="content-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading"><i class="fa fa-fw fa-cog"></i>{{ $title }}<small>{{ $description }}</small></div>
                                <div class="panel-body" style="border-bottom: 1px solid #f4f4f4">
                                    {!! $actionBar->render() !!}
                                </div>
                                <div class="panel-body">
                                    {!! $grid->render() !!}
                                    {!! $paginator->links() !!}
                                </div>
                                <div class="panel-footer">

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