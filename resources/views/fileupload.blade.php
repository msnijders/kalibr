@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Upload</div>

                  <div class="panel-body">
                      <form action="{{ URL::to('importExcel') }}" method="post" enctype="multipart/form-data">
                        <label for="">Upload file:</label>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="file" name="import_file" />
                        <button class="btn btn-primary">Import File</button>
                        </form>
                      </form>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
