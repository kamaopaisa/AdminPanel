@extends('adminlte::page')

@section('title', 'Admin Panel')

@section('content_header')
    <h1 class="m-0 text-dark d-inline">Version</h1>

@stop
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
               
                <div class="card-body">
                    
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{ route('addVersion') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Version Name</label>
                                    <input type="text" class="form-control @error('version_name') is-invalid @enderror" name="version_name" required>
                                    @error('version_name')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Version code</label>
                                    <input type="number" class="form-control @error('version_code') is-invalid @enderror" name="version_code"  step="0.01" required>
                                    @error('version_code')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <button type="submit" class="btn btn-success ">Add Version</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h3 class="mb-3">All Versions</h3>
                    <table class="table table-stripped table-bordered">
                        <thead>
                            <tr>
                                <th>S.no</th>
                                <th>Version Name</th>
                                <th>Version Code</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0;?>
                            @foreach($versions as $version)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$version->version_name}}</td>
                                    <td>{{$version->version_code}}</td>
                                    <td>
                                        
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input is_active" id="customSwitch{{ $version->id }}" data-id="{{$version->id}}" data-status="{{$version->is_active}}" {{ $version->is_active == 0 ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customSwitch{{ $version->id }}"></label>
                                        </div>
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop
@section('js')
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000 // Display success message for 2 seconds
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 3000 // Display error message for 3 seconds
        });
    @endif
    
    $(document).on('change','.is_active',function(){

        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var id = $(this).attr('data-id');
        var status = $(this).attr('data-status');

        $.ajax({
            url: '/version/' + id + '/update-status',
            type: 'POST',
            data: {
                is_active: status
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the request headers
            },
            success: function(response) {
                console.log('Status updated successfully');
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Status updated successfully',
                    showConfirmButton: false,
                    timer: 2000 // Display error message for 3 seconds
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr, status, error) {
                console.log('Error updating status');

                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: error,
                    showConfirmButton: false,
                    timer: 2000 // Display error message for 3 seconds
                }).then(() => {
                    location.reload();
                });
            }
        });
    });
</script>
@stop



