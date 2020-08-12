@extends('admin::layouts.main')

@section('title', $title)

@section('main')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h4">{{ $title }} </h1>
    </div>
    @component("admin::components.flash")@endcomponent
    <div class="my-2 w-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs flex-column flex-sm-row" role="tablist">
                        @foreach($groups as $index => $group)
                            @if(count($group->configs) > 0)
                                <li role="presentation" class="nav-item">
                                    <a href="#config-{{ $group['id'] }}" class="nav-link {{ $index == 0 ? "active" : "" }}" role="tab" data-toggle="tab">{{ $group['title'] }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="col-sm-12">
                    <form class="form-horizontal border  border-top-0" role="form" method="POST" action="{{ route("admin.config.updateAll") }}">
                        {!! csrf_field() !!}
                        {!! method_field("put") !!}
                        <!-- Tab panes -->
                        <div class="container-fluid tab-content tab-content-border" style="padding-top: 20px">
                            @foreach($groups as $group)
                                @if(count($group->configs) > 0)
                                    <div role="tabpanel" class="tab-pane active" id="config-{{ $group['id'] }}">
                                        @foreach($group->configs as $config)
                                            @php
                                                $field = @$fields[$config['name']];
                                                if(is_null($field)){
                                                    continue;
                                                }
                                                //$field->setValue($config['value']);
                                                $element = $field->toElement();
                                                $element->setValue($config['value']);
                                            @endphp
                                            {!! $element->render() !!}
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-2">
                                <button type="submit" class="btn btn-primary">提交</button>

                                <button type="reset" class="btn btn-warning">重置</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection