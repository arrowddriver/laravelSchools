@extends('layouts.app-master')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="bg-light p-5 rounded">
        @auth
        <h1>Dashboard</h1>
        <p class="lead">User Name: {{ $user->username }}</p>
        <p>&nbsp; - {{ $school->name }}</p>
        @php
            $id = $user->id;
        @endphp
        <h1>Edit User</h1>
        <form method="post" action="{{ route('users.update', $id) }}">
            @method('PUT')
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <div class="form-group form-floating mb-3">
                <input type="text" class="form-control" name="username" value="{{ $user->username }}" placeholder="Username" required="required" autofocus>
                <label for="floatingName">Username</label>
                @if ($errors->has('username'))
                    <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                @endif
            </div>

            <div class="form-group mb-3">
                <label for="select2Multiple">Schools</label>
                <select class="select2-multiple form-control" name="schools"
                id="select2Multiple">

                </select>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Update</button>

            @include('auth.partials.copy')
        </form>
        @endauth

        @guest
        <h1>Homepage</h1>
        <p class="lead">Your viewing the home page. Please login to view the restricted data.</p>
        @endguest
    </div>
@endsection

@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            // Select2 Multiple
            @auth
            $('.select2-multiple').select2({
                ajax: {
                    url: "{{ route('getSchools') }} ",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
            var option = new Option("{{ $school->name }}", "{{ $school->id }}", true, true);
            $('.select2-multiple').append(option).trigger('change');
            @endauth
        });
    </script>
@endsection
