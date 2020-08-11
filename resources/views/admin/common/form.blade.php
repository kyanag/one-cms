@extends('admin::layouts.main')

@section('title', $title)

@section('main')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h4">{{ $title }} <small>{{ $description }}</small></h1>
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
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="">
                        {!! $form->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection