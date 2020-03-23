@extends('layouts.master')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark"> {{ trans('block::blocks.title.edit block') }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i
                            class="fas fa-tachometer-alt"></i>
                        {{ trans('core::core.breadcrumb.home') }}</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('admin.block.block.index') }}">{{ trans('block::blocks.title.blocks') }}</a></li>
                <li class="breadcrumb-item active">{{ trans('block::blocks.title.edit block') }}</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>
@stop

@section('styles')
{!! Theme::script('plugins/ckeditor/ckeditor.js') !!}
@stop

@section('content')
{!! Form::open(['route' => ['admin.block.block.update', $block->id], 'method' => 'put']) !!}
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="card card-primary card-outline" style="margin-top: 42px;">
                <div class="card-body">
                    {!! Form::normalInput('name', trans('block::blocks.name'), $errors, $block) !!}
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="card card-primary card-outline tab-content">
                    <?php $i = 0; ?>
                    <?php foreach (LaravelLocalization::getSupportedLocales() as $locale => $language): ?>
                    <?php $i++; ?>
                    <div class="tab-pane {{ App::getLocale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                        @include('block::admin.blocks.partials.edit-fields', ['lang' => $locale])
                    </div>
                    <?php endforeach; ?>
                    <?php if (config('asgard.block.config.partials.normal.edit') !== []): ?>
                    <?php foreach (config('asgard.block.config.partials.normal.edit') as $partial): ?>
                    @include($partial)
                    <?php endforeach; ?>
                    <?php endif; ?>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="button" value="index">
                            <i class="fas fa-angle-left"></i>
                            {{ trans('core::core.button.update and back') }}
                        </button>
                        <button type="submit" class="btn btn-primary">
                            {{ trans('core::core.button.update') }}
                        </button>
                        <a class="btn btn-danger float-right" href="{{ route('admin.block.block.index')}}"><i
                                class="fas fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>

        {!! Form::close() !!}
    </div>
</div>
@stop

@section('footer')
<a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop

@section('shortcuts')
<dl class="dl-horizontal">
    <dt><code>b</code></dt>
    <dd>{{ trans('core::core.back to index', ['name' => 'blocks']) }}</dd>
</dl>
@stop

@section('scripts')
<script type="text/javascript">
    $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.block.block.index') ?>" }
                ]
            });
        });
</script>

<script>
    $( document ).ready(function() {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });

            $('input[type="checkbox"]').on('ifChecked', function(){
                $(this).parent().find('input[type=hidden]').remove();
            });

            $('input[type="checkbox"]').on('ifUnchecked', function(){
                var name = $(this).attr('name'),
                    input = '<input type="hidden" name="' + name + '" value="0" />';
                $(this).parent().append(input);
            });
        });
</script>
@stop