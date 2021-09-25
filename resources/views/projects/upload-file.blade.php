@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{-- {{ trans('admin/hardware/general.view') }} {{ $asset->asset_tag }} --}}
    @parent
@stop

{{-- Page content --}}
@section('content')

    <div class="row">

        <div class="col-md-12">

            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li>
                        <a href="#files" data-toggle="tab">
            <span class="hidden-lg hidden-md">
              <i class="fa fa-files-o" aria-hidden="true"></i>
            </span>
                            <span class="hidden-xs hidden-sm">
              {{ trans('general.files') }}
            </span>
                        </a>
                    </li>
                    @can('update', \App\Models\File::class)
                        <li class="pull-right">
                            <a href="#" data-toggle="modal" data-target="#uploadFileModal">
                                <i class="fa fa-paperclip" aria-hidden="true"></i>
                                {{ trans('button.upload') }}
                            </a>
                        </li>
                    @endcan
                </ul>
                <div class="tab-content">

        <div class="tab-pane fade" id="files">
          <div class="row">
            <div class="col-md-12">

              @if ($asset->uploads->count() > 0)
              <table
                      class="table table-striped snipe-table"
                      id="assetFileHistory"
                      data-pagination="true"
                      data-id-table="assetFileHistory"
                      data-search="true"
                      data-side-pagination="client"
                      data-show-columns="true"
                      data-show-refresh="true"
                      data-sort-order="desc"
                      data-sort-name="created_at"
                      data-show-export="true"
                      data-export-options='{
                         "fileName": "export-asset-{{ $asset->id }}-files",
                         "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                       }'
                                            data-cookie-id-table="assetFileHistory">
                                        <thead>
                                        <tr>
                                            <th data-visible="true" data-field="icon">{{trans('general.file_type')}}</th>
                                            <th class="col-md-2" data-searchable="true" data-visible="true" data-field="notes">{{ trans('general.notes') }}</th>
                                            <th class="col-md-2" data-searchable="true" data-visible="true" data-field="image">{{ trans('general.image') }}</th>
                                            <th class="col-md-2" data-searchable="true" data-visible="true" data-field="filename">{{ trans('general.file_name') }}</th>
                                            <th class="col-md-2" data-searchable="true" data-visible="true" data-field="download">{{ trans('general.download') }}</th>
                                            <th class="col-md-2" data-searchable="true" data-visible="true" data-field="created_at">{{ trans('general.created_at') }}</th>
                                            <th class="col-md-1" data-searchable="true" data-visible="true" data-field="actions">{{ trans('table.actions') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach ($asset->uploads as $file)
                                            <tr>
                                                <td><i class="{{ \App\Helpers\Helper::filetype_icon($file->filename) }} icon-med" aria-hidden="true"></i></td>
                                                <td>
                                                    @if ($file->note)
                                                        {{ $file->note }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ( \App\Helpers\Helper::checkUploadIsImage($file->get_src('assets')))
                                                        <a href="{{ route('show/assetfile', ['assetId' => $asset->id, 'fileId' =>$file->id]) }}" data-toggle="lightbox" data-type="image" data-title="{{ $file->filename }}" data-footer="{{ \App\Helpers\Helper::getFormattedDateObject($asset->last_checkout, 'datetime', false) }}">
                                                            <img src="{{ route('show/assetfile', ['assetId' => $asset->id, 'fileId' =>$file->id]) }}" style="max-width: 50px;">
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $file->filename }}
                                                </td>
                                                <td>
                                                    @if ($file->filename)
                                                        <a href="{{ route('show/assetfile', [$asset->id, $file->id]) }}" class="btn btn-default">
                                                            <i class="fa fa-download" aria-hidden="true"></i>
                                                        </a>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($file->created_at)
                                                        {{ \App\Helpers\Helper::getFormattedDateObject($asset->last_checkout, 'datetime', false) }}
                                                    @endif
                                                </td>


                                                <td>
                                                    @can('update', \App\Models\Asset::class)
                                                        <a class="btn delete-asset btn-sm btn-danger btn-sm" href="{{ route('delete/assetfile', [$asset->id, $file->id]) }}" data-tooltip="true" data-title="Delete" data-content="{{ trans('general.delete_confirm', ['item' => $file->filename]) }}"><i class="fa fa-trash icon-white" aria-hidden="true"></i></a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                @else

                                    <div class="alert alert-info alert-block">
                                        <i class="fa fa-info-circle"></i>
                                        {{ trans('general.no_results') }}
                                    </div>
                                @endif

                            </div> <!-- /.col-md-12 -->
                        </div> <!-- /.row -->
                    </div> <!-- /.tab-pane files -->
                </div> <!-- /. tab-content -->
            </div> <!-- /.nav-tabs-custom -->
        </div> <!-- /. col-md-12 -->
    </div> <!-- /. row -->

    @can('update', \App\Models\Asset::class)
        @include ('modals.upload-file', ['item_type' => 'asset', 'item_id' => $asset->id])
    @endcan

@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table')

@stop