@extends('layouts.master')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark"> {{ trans('block::blocks.title.blocks') }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a
                        href="{{ route('dashboard.index') }}"><i
                        class="fas fa-tachometer-alt"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
                <li class="breadcrumb-item active"> {{ trans('block::blocks.title.blocks') }}</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="row justify-content-end">
                <div class="btn-group right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.block.block.create') }}" class="btn btn-primary"
                        style="padding: 4px 10px;">
                        <i class="fas fa-plus mr-1"></i> {{ trans('block::blocks.button.create block') }}
                    </a>
                </div>
            </div>
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="index-table" class="data-table table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>{{ trans('block::blocks.name') }}</th>
                                    <th>{{ trans('core::core.table.created at') }}</th>
                                    <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>{{ trans('block::blocks.name') }}</th>
                                    <th>{{ trans('core::core.table.created at') }}</th>
                                    <th>{{ trans('core::core.table.actions') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</div>

@include('core::partials.delete-modal')
@stop

@section('footer')
<a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
<dl class="dl-horizontal">
    <dt><code>c</code></dt>
    <dd>{{ trans('block::blocks.title.create block') }}</dd>
</dl>
@stop

@section('scripts')
<?php $locale = App::getLocale(); ?>
<script type="text/javascript">
    $( document ).ready(function() {
        drawTable();
    });

    function drawTable(){
        var pathname = window.location.origin;
        var url = pathname + '/api/block/index';
        
       $('#index-table').DataTable({
            "processing": true,
            "serverSide": true,
            "filter": true,
            "order": [ 1, "desc" ],
            "language": {
            "url": pathname + '/modules/core/js/vendor/datatables/{$locale}.json'
            },
            "ajax":{
                "url": url,
                "dataType": "json",
                "type": "POST"
            },
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "created_at" },
                { "data": "actions" },
            ]
        });
    }
</script>
@stop