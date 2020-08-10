<?php
$unique_id = uniqid("search-bar");
/** @var $urlCreator  \App\Supports\UrlCreator */
?>

<div class="row">
    <div class="col-sm-12">
        <div class="float-left">
            <a class="btn btn-sm btn-primary" data-toggle="collapse" href="#{{ $unique_id }}"><i class="fa fa-filter"></i>筛选</a>
        </div>
        <div class="float-right">
            <a class="btn btn-sm btn-success" href="{{ $urlCreator->route("admin.*.create") }}"><i class="fa fa-plus"></i>新建</a>
            <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                排序 <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                @foreach($sortableFields as $field)
                    <li><a href="{{ $urlCreator->current([DESC_QUERY_NAME => $field->name]) }}"> {{ $field->label }} 倒序</a></li>
                    <li><a href="{{ $urlCreator->current([ASC_QUERY_NAME => $field->name]) }}">{{ $field->label }} 正序</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col-sm-12" style="padding-top: 20px;">
        <div id="{{ $unique_id }}" class="collapse" >
            {!! $searchBar->render() !!}
        </div>
    </div>
</div>