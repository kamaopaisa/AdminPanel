@extends('adminlte::page')

@section('title', 'Admin Panel')

@section('content_header')
    <h1 class="m-0 text-dark d-inline">Notifications</h1>
    <button onclick="startFCM()" class="btn btn-danger btn-flat float-right ">Allow notification</button>
@stop
@section('css')
<style>
    .select2-container--default .select2-selection--single,
    .select2-container--default .select2-selection--multiple {
        background-color: #343a40;
        color: #fff;
        border-color: #6c6d6e;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #191f25;
    }
</style>
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
                    <form action="{{ route('send.web-notification') }}" method="POST">
                        @csrf
                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Select Users</label>
                                    <select name="users[]" id="users" multiple>
                                        <option></option>
                                        @foreach($users as $id => $name)
                                            <option value="{{$id}}">{{$name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Message Title</label>
                                    <input type="text" class="form-control" name="title" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Message Body</label>
                                    <textarea class="form-control" name="body" required></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Send Notification</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop
@section('js')

<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
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

    $('#users').select2({
        width:'100%',
        placeholder:'Select Users'
    });
</script>
<script>
    var firebaseConfig = {
        apiKey: "AIzaSyDOc-nOqWxiY78qxmSfp3QoYsXhsQxqkH0",
        authDomain: "kamao-paisa-2c0a4.firebaseapp.com",
        projectId: "kamao-paisa-2c0a4",
        storageBucket: "kamao-paisa-2c0a4.appspot.com",
        messagingSenderId: "933802149068",
        appId: "1:933802149068:web:d26f8d88931659161aee69",
        measurementId: "G-TLB7QS8VF7"
    };
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
    function startFCM() {
        messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function (response) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route("store.token") }}',
                    type: 'POST',
                    data: {
                        token: response
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Device Token Stored.',
                            showConfirmButton: false,
                            timer: 2000 // Display success message for 2 seconds
                        });
                    },
                    error: function (error) {
                        alert(error);
                    },
                });
            }).catch(function (error) {
                alert(error);
            });
    }
    messaging.onMessage(function (payload) {
        const title = payload.notification.title;
        const options = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(title, options);
    });
</script>
@stop



