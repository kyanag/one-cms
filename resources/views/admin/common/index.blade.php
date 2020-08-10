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
                            <div class="card card-default">
                                <div class="card-header"><i class="fa fa-fw fa-cog"></i>{{ $title }}<small>{{ $description }}</small></div>
                                <div class="card-body">
                                    {!! $actionBar->render() !!}
                                </div>
                                <hr>
                                <div class="card-body">
                                    {!! $grid->render() !!}
                                    {!! $paginator->links() !!}
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