@extends('adminlte::page')

@section('title', 'Admin Panel')

@section('content_header')
    <h1 class="m-0 text-dark">Change Password</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form id="changePasswordForm" method="POST" action="{{URL('/admin/change_password')}}">
                        @csrf
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" placeholder="Enter Old Password">
                            @error('current_password')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" placeholder="Enter New Password">
                            @error('new_password')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="new_password_confirmation">Confirm New Password</label>
                            <input id="new_password_confirmation" type="password" name="new_password_confirmation" class="form-control" placeholder="Confirm New Password">
                            @error('new_password_confirmation')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- <div class="form-group mb-0">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="terms" class="custom-control-input" id="exampleCheck1">
                                <label class="custom-control-label" for="exampleCheck1">I agree to the <a href="#">terms of service</a>.</label>
                            </div>
                        </div> -->
                        <!-- <div class="card-footer"> -->
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        <!-- </div> -->
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop
@section('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    </script>

@stop