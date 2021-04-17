@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <div class="d-flex flex-column align-items-center">
            <div class="col-md-8">
                <div class="university-admins">
                    @if ($universityAdminUsers->count() == 0)
                        <h3 style="text-align: center">No Admin University Users</h3>
                    @else
                        <h3 style="text-align: center">Admin University</h3>
                        <table class="table my-4">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Admin Name</th>
                                    <th scope="col">Admin Email</th>
                                    <th scope="col">University</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($universityAdminUsers as $univAdmin)
                                    <tr>
                                        <th scope="row">
                                            {{ $univAdmin->name }}
                                        </th>
                                        <td>
                                            {{ $univAdmin->email }}
                                        </td>
                                        <td>
                                            {{ $univAdmin->University->name }}
                                        </td>
                                        <td>
                                            {{ $univAdmin->University->phone }}
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#user-{{ $univAdmin->id }}">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                    {{-- Modal --}}
                                    <div class="modal fade" id="user-{{ $univAdmin->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">DELETE USER</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure to delete {{ $univAdmin->name }} user ?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('super-admin.delete-user') }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="userId" value="{{ $univAdmin->id }}">
                                                    <button type="submit" class="btn btn-danger">Yes</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Nope</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $universityAdminUsers->links() }}
                    @endif
                </div>
                <hr>
                <div class="user-students mt-4">
                    @if ($userStudents->count() == 0)
                        <h3 style="text-align: center">No Student Users</h3>
                    @else
                        <h3 style="text-align: center">Student Users</h3>
                        <table class="table my-4">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Admin Name</th>
                                    <th scope="col">Admin Email</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($userStudents as $student)
                                    <tr>
                                        <th scope="row">
                                            {{ $student->name }}
                                        </th>
                                        <td>
                                            {{ $student->email }}
                                        <td>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#user-{{ $student->id }}">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                        {{-- Modal --}}
                                        <div class="modal fade" id="user-{{ $student->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">DELETE USER</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure to delete {{ $student->name }} user ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('super-admin.delete-user') }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="userId" value="{{ $student->id }}">
                                                        <button type="submit" class="btn btn-danger">Yes</button>
                                                    </form>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Nope</button>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $userStudents->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>

{{-- @include('layouts.js_jquery') --}}
@endsection