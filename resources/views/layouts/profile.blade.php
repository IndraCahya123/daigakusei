@extends('layouts.app')

@section('content')
    {{-- Admin Web Profile --}}
    @hasrole('super-admin')
        @include('layouts.profile_template')
    @endhasrole

    {{-- Admin University Profile --}}
    @hasrole('university-admin')
        @include('layouts.profile_template')
    @endhasrole

    {{-- Admin Student Profile --}}
    @hasrole('user-student')
        @include('layouts.profile_template')
    @endhasrole
@endsection