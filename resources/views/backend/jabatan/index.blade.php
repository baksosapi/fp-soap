@extends('layouts.app')
@push('css')
<link href="{{ asset('plugin/datatables/1.10.12/css/jquery.dataTables.min.css') }}" rel="stylesheet">
@endpush
@push('scripts')
<script src="{{ asset('plugin/datatables/1.10.12/js/jquery.dataTables.min.js') }}"></script>
@endpush
@section('content')
<script type="text/javascript">
    $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#jabatan-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'url': "{{ route('get.datatables.jabatan') }}",
                'type': 'POST'
            },
            columns: [
                {data: 'jabatan_id', name: 'jabatan_id'},
                {data: 'nama', name: 'nama'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'action', name: 'action', class: 'text-center', orderable: false, searchable: false}
            ]
        });
        $('#jabatan-table').on( 'draw.dt', function () {
            $('.destroyData').click(function() {
                var id = $(this).data('id');
                alertify.confirm('Apakah anda yakin menghapus data ini ?').set('onok', function(closeEvent) {
                    $('#formDestroy' + id).submit();
                }).setHeader('Mohon Konfirmasi').set('labels', {ok:'Ya', cancel:'Tidak'});
            });
        });
    });
</script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <div class="card card-default">
                <div class="card-header">
                    Jabatan
                    <a href="{{route('jabatan.create')}}" class="btn btn-primary btn-sm float-right">Add </a>
                </div>
                <div class="card-body">
                    <table id="jabatan-table" class="table table-condensed dataTable no-footer" role="grid">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 30px;">No</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center" style="width: 90px;">Created At</th>
                                <th class="text-center" style="width: 90px;">Updated At</th>
                                <th class="text-center" style="width: 100px;">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection