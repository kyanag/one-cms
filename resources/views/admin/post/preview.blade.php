@extends('admin::layouts.main')

@section('title', $title)

@section('main')
    <style>
        .card-sidebar{
            border-color: #eee;

        }
        .card-sidebar > .card-header{
            color: #333;
            background-color: #f5f5f5;
            border-bottom: 0;
        }
    </style>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h4">{{ $title }} <small>{{ $description }}</small></h1>
    </div>
    @component("admin::components.flash")@endcomponent
    <div class="card" style="width: 220px">
        <div class="card-header">
            <i class="fa fa-bars"></i> <span>栏目</span>
        </div>
        <ul class="list-group list-group-flush">
            @foreach($categories as $category)
                <a href="{{ $urlCreator->index(['category_id' => $category['id']]) }}" class="list-group-item list-group-item-action">{{ str_repeat(" -- ", $category['depth']-1) }}{{ $category['title'] }}</a>
            @endforeach
        </ul>
    </div>
@endsection