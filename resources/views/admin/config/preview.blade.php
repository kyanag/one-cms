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
                                <div class="panel-heading"><i class="fa fa-cog"></i> {{ $title }}</div>
                                <div class="panel-body">
                                    <form class="form-horizontal" role="form" method="POST" action="{{ route("admin.config.updateAll") }}">
                                        {!! csrf_field() !!}
                                        {!! method_field("put") !!}
                                        <div>
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" role="tablist">
                                                @foreach($groups as $index => $group)
                                                    @if(count($group->configs) > 0)
                                                <li role="presentation" class="{{ $index == 0 ? "active" : "" }}">
                                                    <a href="#config-{{ $group['id'] }}" role="tab" data-toggle="tab">{{ $group['title'] }}</a>
                                                </li>
                                                    @endif
                                                @endforeach
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content tab-content-border" style="padding-top: 20px">
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
                </div>
            </div>
        </div>
    </div>
    <script>

    </script>
@endsection