<div class="container d-flex flex-column align-items-center"
style="margin-top: 110px">
    <div class="container d-flex flex-column shadow bg-white rounded p-3 position-relative" 
    style="height: 60vh; max-width: 55vh;">
        <div class="photo-profile position-absolute"
        style="z-index: 1; left: 50%; top: -110px; transform: translateX(-50%)">
        @if ($user->thumbnail == null)
            <img src="{{ asset('/images/default_image_thumbnail.png') }}" 
            alt="Photo Profile" class="rounded-circle shadow" 
            style="height: 200px; width: 200px">
        @else
            <img src="{{  asset('/storage/' . $user->thumbnail) }}" 
            alt="Photo Profile" class="rounded-circle shadow bg-white" 
            style="height: 200px; width: 200px">
        @endif
        </div>

        <h1 style="text-align: center">Profile</h1>

        <div class="info d-flex flex-column" style="margin-top: 50px">
            <div class="name" style="text-align: center">
                <h5>Nama</h5>
                <h3>{{ $user->name }}</h3>
            </div>
            <div class="email mt-4" style="text-align: center">
                <h5>Email</h5>
                <h3>{{ $user->email }}</h3>
            </div>
        </div>
        <button type="button" class="btn btn-primary shadow position-absolute" 
        data-toggle="modal" 
        data-target="#edit-{{ $user->id }}"
        style="bottom: 20px; right:20px;">EDIT</button>
    </div>
</div>
{{-- edit university profile modal --}}
<div class="modal fade" id="edit-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">UPDATE PROFILE</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('home.profile-update') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="form-group">
                    <input type="file" name="thumbnail" id="thumbnail">
                    @error('thumbnail')   
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Nama</label>
                    <input type="text" class="form-control" id="value" value="{{ $user->name }}" name="name" required>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Email</label>
                    <input type="text" class="form-control" id="value" value="{{ $user->email }}" name="email" required>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>