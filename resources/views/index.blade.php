@extends('layouts.auth')

@section('content')
<div class="col-md-12">
    <div class="jumbotron jumbotron-fluid">
      <div class="container text-center">
        <h1>Welcome To My App</h1>      
        <p>Login to use</p>
      </div>
    </div>
</div>
@stop
@push('script')
<script type="text/javascript">
    $().ready(function() {
        demo.checkFullPageBackgroundImage();
    });
</script>
@endpush