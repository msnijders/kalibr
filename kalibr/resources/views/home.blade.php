@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Upload</div>

                <div class="panel-body">
                    <form action="importData" method="post">
                      <label for="">Upload file:</label>
                      <input type="file" name="file" value="">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="submit" value="upload">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
