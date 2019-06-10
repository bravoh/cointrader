@extends(getCurrentTemplate() . '.layouts.default')
@section('styles')
<link href="{{ URL::asset('public/css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('public/css/datatables/dataTables.responsive.css') }}" rel="stylesheet" />
@stop
@section('scripts')
<script src="{{ URL::asset('public/js/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('public/js/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('public/js/datatables/dataTables.responsive.js') }}"></script>
<script>
$(document).ready(function() {
    $('#dataTables-example').DataTable({
        responsive: true,
        "bPaginate": false
    });
});
</script>
@stop
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h1>All available crypto markets</h1>
    </div>
    <div class="panel-body">
    	Coming soon
    </div>
</div>
@stop