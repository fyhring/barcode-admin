@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-push-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit barcode</div>

                <div class="panel-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="/codes/{{ $id }}" method="post" id="vue" class="form-horizontal">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="col-md-3 control-label">Name</label>
                            <div class="col-md-9">
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    value="{{ old('name', $barcode->name) }}" />
                            </div>
                        </div>

                        <unique-barcode-input
                            barcode={{ old('barcode', $barcode->barcode) }}>
                        </unique-barcode-input>

                        <p></p>

                        <div class="form-group">
                            <label class="col-md-3 control-label">&nbsp;</label>
                            <div class="col-md-9">
                                <input type="submit" value="Save" class="btn btn-primary" />
                                <a href="{{ action('BarcodeController@edit', ['id' => $id]) }}" class="btn btn-default">Reset</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
