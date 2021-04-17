@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <div class="header">
            <div class="d-flex justify-content-between align-items-center">
                <h2>CRITERIA LIST</h2>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-criteria-modal">
                    ADD NEW CRITERIA
                </button>
            </div>
        </div>
        <hr>
        <div class="body d-flex flex-column align-items-center">
            @if ($criterias->count() == 0)
                <h2 style="text-align: center" class="mt-5">Criteria is Empty</h2>
            @else
                <div class="col-md-8">
                    <table class="table my-4">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Criteria</th>
                                <th scope="col">Highest Value</th>
                                <th scope="col">Average Value</th>
                                <th scope="col">Lowest Value</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($criterias as $criteria)
                                <tr>
                                    <th scope="row">
                                        {{ $criteria->name }}
                                    </th>
                                    <td>
                                        {{ $criteria->highest_value }}
                                    </td>
                                    <td>
                                        {{ $criteria->average_value }}
                                    </td>
                                    <td>
                                        {{ $criteria->lowest_value }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#criteria-update-{{ $criteria->id }}">
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#criteria-delete-{{ $criteria->id }}">
                                            Delete
                                        </button>
                                        {{-- Delete Criteria Modal --}}
                                        <div class="modal fade" id="criteria-delete-{{ $criteria->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">DELETE CRITERIA</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure to delete {{ $criteria->name }} criteria ?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('super-admin.delete-criteria') }}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="criteriaId" value="{{ $criteria->id }}">
                                                            <button type="submit" class="btn btn-danger">Yes</button>
                                                        </form>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Nope</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                        {{-- Edit Criteria Modal --}}
                                        <div class="modal fade" id="criteria-update-{{ $criteria->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">UPDATE CRITERIA</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('super-admin.update-criteria') }}" method="post">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="form-group">
                                                            <label for="exampleFormControlInput1">Criteria Name</label>
                                                            <input type="text" class="form-control" id="nameCriteria" value="{{ $criteria->name }}" name="name" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleFormControlInput1">Highest Value</label>
                                                            <input type="text" class="form-control" id="value" value="{{ $criteria->highest_value }}" name="highest_value" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleFormControlInput1">Average Value</label>
                                                            <input type="text" class="form-control" id="value" value="{{ $criteria->average_value }}" name="average_value" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleFormControlInput1">Lowest Value</label>
                                                            <input type="text" class="form-control" id="value" value="{{ $criteria->lowest_value }}" name="lowest_value" required>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="hidden" class="form-control" id="updateId" value="{{ $criteria->id }}" name="updateId">
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            {{ $criterias->links() }}
        </div>
    </div>
    {{-- Add new modal --}}
    <div class="modal fade" id="add-criteria-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ADD NEW CRITERIA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('super-admin.add-criteria') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Criteria Name</label>
                        <input type="text" class="form-control" id="nameCriteria" placeholder="eg: Akreditasi Jurusan" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Highest Value</label>
                        <input type="text" class="form-control" id="value" placeholder="eg: A, Sangat Bagus, etc." name="highest_value" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Average Value</label>
                        <input type="text" class="form-control" id="value" placeholder="eg: B, Bagus, etc" name="average_value" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Lowest Value</label>
                        <input type="text" class="form-control" id="value" placeholder="eg: C, Biasa, etc" name="lowest_value" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection