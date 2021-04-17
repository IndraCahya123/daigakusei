@extends('layouts.app')

@section('content')
<div class="container university-profile d-flex shadow bg-white rounded p-3 my-4 position-relative">
    <div class="thumbnail mr-5">
        <div class="background  d-flex flex-column align-items-center h-100 p-3" style="background-image: linear-gradient(180deg,#03fcba,#03b1fc); border-radius: 20px;">
            @if (!isset($profile->thumbnail))
            <img style="height: 200px; width: 200px" class="rounded-circle shadow-lg" src="{{ asset('/images/default_image_thumbnail.png') }}" alt="Default Profile Picture">
            @else    
            <img src="{{ asset('/storage/' . $profile->thumbnail) }}" style="height: 200px; width: 200px" class="rounded-circle shadow-lg">
            @endif
            <strong class="my-3">Admin : {{ $profile->author->name }}</strong>
        </div>
    </div>
    <div class="about d-flex flex-column py-2 w-100">
        <h1 class="mb-6">{{ $profile->name }}</h1>
        <div class="phone d-flex text-secondary align-items-center">
            <img src="{{ asset('/images/phone.png') }}" alt="Phone" 
            style="height: 20px; width: 20px;" 
            class="rounded-cirle mr-2">
            <span>{{ $profile->phone }}</span>
        </div>
        <div class="info mt-4 pr-3" style="max-height: 300px; overflow: auto;">
            <p class="text-justify">{!! nl2br($profile->about) !!}</p>
        </div>
    </div>
    <button type="button" class="btn btn-danger position-absolute" style="right: 20px; top: 20px;"
    data-toggle="modal" data-target="#profile-{{ $profile->id }}">
        Edit
    </button>
    {{-- edit university profile modal --}}
    <div class="modal fade" id="profile-{{ $profile->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">UPDATE UNIVERSITY PROFILE</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('university.university-profile-update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <label for="exampleFormControlInput1">University Name</label>
                            <input type="text" class="form-control" id="nameUniversity" value="{{ $profile->name }}" name="name" required>
                        </div>
                        <div class="form-group">
                            <input type="file" name="thumbnail" id="thumbnail">
                            @error('thumbnail')   
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Phone</label>
                            <input type="text" class="form-control" id="value" value="{{ $profile->phone }}" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">About</label>
                            <textarea class="form-control" id="value" name="about" rows="3" placeholder="Tell Us About your University..." required>{{ $profile->about }}</textarea>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="user_id" value="{{ $profile->id }}">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container majors-list d-flex flex-column align-items-center my-5">
    <div class="header-list d-flex justify-content-between align-items-center w-75">
        <h3 class="mt-2">MAJORS LIST</h3>
        <button type="button" class="btn btn-primary shadow" data-toggle="modal" data-target="#add-new-majors">
            Add New Majors
        </button>
        {{-- add majors modal --}}
        <div class="modal fade" id="add-new-majors" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ADD NEW MAJOR</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('university.add-new-major') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nama Jurusan</label>
                                <input type="text" class="form-control" id="value" name="name" required>
                            </div>
                            <hr>
                            <p style="text-align: center">Kriteria</p>
                            @foreach ($criterias as $criteria)
                            <div class="form-group">
                                <label for="input-{{ $criteria->id }}">{{ $criteria->name }}</label>
                                <select class="form-control" id="select-{{ $criteria->id }}"
                                    name="select-{{ $criteria->id }}" required>
                                    <option disabled selected>Choose One Value</option>
                                    <option value="{{ $criteria->highest_value }}">{{ $criteria->highest_value }}</option>
                                    <option value="{{ $criteria->average_value }}">{{ $criteria->average_value }}</option>
                                    <option value="{{ $criteria->lowest_value }}">{{ $criteria->lowest_value }}</option>
                                </select>
                            </div>
                            @endforeach
                            <div class="modal-footer">
                                <input type="hidden" name="univ_id" value="{{ $profile->id }}">
                                <button type="submit" class="btn btn-primary">Add</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="w-100">
    <div class="body-list d-flex justify-content-center">
        @if ($selectedUniv->majors->count() == 0)
            <h1>There's No Major Added</h1>
        @else
        <table class="table my-4">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Name</th>
                    @foreach ($criterias as $criteria)
                        <th scope="col">
                            {{ $criteria->name }}
                        </th>
                    @endforeach
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($selectAllMajors as $item)
                <tr>
                    <th scope="row">
                        {{ $item->name }}
                    </th>
                    @foreach ($item->about as $about)
                        <td>
                            {{ $about['value'] }}
                        </td>
                    @endforeach
                    <td>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#update-major-{{ $item->id }}">
                            Update
                        </button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-major-{{ $item->id }}">
                            Delete
                        </button>
                        {{-- edit university profile modal --}}
                        <div class="modal fade" id="update-major-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">UPDATE MAJOR</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('university.update-major') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('patch')
                                            <div class="form-group">
                                                <label for="name">Nama Jurusan</label>
                                                <input type="text" class="form-control" id="value" value="{{ $item->name }}" name="name" required>
                                            </div>
                                            <hr>
                                            <p style="text-align: center">Kriteria</p>
                                            @foreach ($criterias as $criteria)
                                            <div class="form-group">
                                                <label for="input-{{ $criteria->name }}">{{ $criteria->name }}</label>
                                                <select class="form-control" id="select-{{ $criteria->name }}"
                                                name="select-{{ $criteria->id }}" required>                                            
                                                    <option selected value="{{ $item->about[($criteria->id)-1]['value'] }}">{{ $item->about[($criteria->id)-1]['value'] }}</option>
                                                    <option value="{{ $criteria->highest_value }}">{{ $criteria->highest_value }}</option>
                                                    <option value="{{ $criteria->average_value }}">{{ $criteria->average_value }}</option>
                                                    <option value="{{ $criteria->lowest_value }}">{{ $criteria->lowest_value }}</option>
                                                </select>
                                            </div>
                                            @endforeach
                                            <div class="modal-footer">
                                                <input type="hidden" name="major_id" value="{{ $item->id }}">
                                                <input type="hidden" name="univ_id" value="{{ $item->univ_id }}">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                    {{-- delete major modal --}}
                    <div class="modal fade" id="delete-major-{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">DELETE MAJOR</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure to delete {{ $item->name }} from major ?</p>
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('university.delete-major') }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="majorId" value="{{ $item->id }}">
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
        @endif
    </div>
</div>
@endsection

