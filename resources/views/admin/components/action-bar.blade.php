<?php
$unique_id = uniqid("search-bar");
/** @var $urlCreator  \App\Supports\UrlCreator */
?>

<div class="row">
    <div class="col-md">
        <div class="float-left">
            <a class="btn btn-sm btn-primary" data-toggle="collapse" href="#{{ $unique_id }}"><i class="fa fa-filter"></i>筛选</a>
        </div>
        <div class="float-right">
            <a class="btn btn-sm btn-success" href="{{ $urlCreator->route("admin.*.create") }}"><i class="fa fa-plus"></i>新建</a>
            <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                排序 <span class="caret"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-right">
                @foreach($sortableFields as $field)
                    <a class="dropdown-item" href="{{ $urlCreator->current([DESC_QUERY_NAME => $field->getName()]) }}">按 <b>{{ $field->getLabel() }}</b> 降序<i class="fa fa-sort-amount-down" aria-hidden="true"></i></a>
                    <a class="dropdown-item" href="{{ $urlCreator->current([ASC_QUERY_NAME => $field->getName()]) }}">按 <b>{{ $field->getLabel() }}</b> 升序<i class="fa fa-sort-amount-up" aria-hidden="true"></i></a>
                    <div class="dropdown-divider"></div>
                @endforeach
            </ul>
        </div>
    </div>
</div>
<div class="row justify-content-md-center">
    <div class="col-md-8" style="padding-top: 20px;">
        <div id="{{ $unique_id }}" class="collapse pb-3" >
            {!! $searchBar->render() !!}
        </div>
    </div>
</div>