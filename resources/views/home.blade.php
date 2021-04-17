@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-align-center">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @hasrole('super-admin')
                        {{ __('Hello Admin ' . Auth::user()->name . ', You are logged in!') }}
                        @if (Auth::user()->unreadNotifications()->count() > 0)
                            <table class="table my-4">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Admin Name</th>
                                        <th scope="col">Admin Email</th>
                                        <th scope="col">University</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Password</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach (Auth::user()->unreadNotifications as $notification)
                                <form action="{{ route('super-admin.admin-univ-success-registered') }}" method="post">
                                    @csrf
                                    <tr>
                                        <th scope="row">
                                            <input type="hidden" name="adminName" value="{{ $notification->data['admin_name'] }}">
                                            {{ $notification->data['admin_name'] }}
                                        </th>
                                        <td>
                                            <input type="hidden" name="adminEmail" value="{{ $notification->data['admin_email'] }}">
                                            {{ $notification->data['admin_email'] }}
                                        </td>
                                        <td>
                                            <input type="hidden" name="university" value="{{ $notification->data['university'] }}">
                                            {{ $notification->data['university'] }}
                                        </td>
                                        <td>
                                            <input type="hidden" name="phone" value="{{ $notification->data['phone'] }}">
                                            {{ $notification->data['phone'] }}
                                        </td>
                                        <td>
                                            <input type="hidden" name="notifId" value="{{ $notification->id }}">
                                            <input type="hidden" name="password" value="{{ $notification->data['password'] }}">
                                            {{ Str::limit($notification->data['password'], 5, '..') }}
                                        </td>
                                        <td>
                                            <button type="submit" class="btn-success btn-sm">
                                                Accept
                                            </button>
                                        </form>
                                        <form method="post" action="{{ route('super-admin.admin-univ-dismissed') }}">
                                            @csrf
                                            <input type="hidden" name="adminEmail" value="{{ $notification->data['admin_email'] }}" required>
                                            <input type="hidden" name="adminUnivDismissedId" value="{{ $notification->id }}">
                                            <button type="submit" class="btn-danger btn-sm">Dismiss</button>
                                        </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <span></span>
                        @endif
                    @endhasrole
                    @hasrole('university-admin')
                        {{ __('Hello Admin ' . Auth::user()->name . ', You are logged in!') }}
                    @endhasrole
                    @hasrole('user-student')
                        {{ __('Hello User ' . Auth::user()->name . ', You are logged in!') }}
                    @endhasrole
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
