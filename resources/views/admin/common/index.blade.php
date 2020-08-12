@extends('admin::layouts.main')

@section('title', $title)

@section('main')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h4">{{ $title }} <small>{{ $description }}</small></h1>
    </div>
    @component("admin::components.flash")@endcomponent
    <div class="my-2 w-100">
        {!! $actionBar->render() !!}
    </div>
{{--    <h2>Section title</h2>--}}
    <div class="table-responsive">
        {!! $grid->render() !!}
        {!! $paginator->links("vendor.pagination.bootstrap-4") !!}
    </div>
@endsection