@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                        <div class="btn-group pull-right">
                            <a href="{{ action('BarcodeController@create') }}" class="btn btn-info">+ Create barcode</a>
                        </div>
                    List
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <table class="table table-bordered table-striped table-hover">

                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="35%">Name</th>
                                <th width="35%">Code</th>
                                <th width="25%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entries as $entry)
                                <tr>
                                    <td>{{ $entry->id }}</td>
                                    <td>{{ $entry->name }}</td>
                                    <td class="monospace">{{ $entry->barcode }}</td>
                                    <td>
                                        <a href="#" class="btn btn-info download"
                                            data-barcode="{{ $entry->barcode }}"
                                            data-name="{{ str_slug($entry->name) }}"
                                            title="Download">
                                            <i class="fa fa-download"></i>
                                        </a>
                                        <a href="{{ action('BarcodeController@edit', ['id' => $entry->id]) }}"
                                            class="btn btn-default" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <form
                                            action="{{ action('BarcodeController@destroy', ['id' => $entry->id]) }}"
                                            method="post"
                                            class="form-inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                            <button class="btn btn-danger" type="submit">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="hidden">
    <canvas id="canvas"></canvas>
</div>

<script>
    window.onload = function() {
        window.downloadBarcode.default.init();
    };
</script>

@endsection
