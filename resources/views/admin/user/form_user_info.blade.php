<form class="form-horizontal px-0" method="POST">
    {{ csrf_field() }}
    <div class="alert alert-danger py-2">Không thay đổi thông tin của người dùng!</div>
    @error('username')
    <div class="text-danger pb-1 mb-2">{{ $message }}</div>
    @enderror
    <div class="@error('username') is-invalid @enderror form-outline mb-3">
        <input type="text" name="username" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
            id="username" value="{{ $user->username }}" />
        <label class="form-label" for="username">User name</label>
    </div>
    <div class="form-outline mb-3">
        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name"
            value="{{ $user->name }}" />
        <label class="form-label" for="name">Tên hiển thị</label>
    </div>
    <div class="form-outline mb-3">
        <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email"
            value="{{ $user->email }}" />
        <label class="form-label" for="name">Email</label>
    </div>
    <div class="form-group">
        <label for="introduce">Giới thiệu bản thân (Max. 500)</label>
        <textarea maxlength="500" rows="6" class="form-control basicarea text-black {{ $errors->has('introduce') ? 'is-invalid' : '' }}" id="introduce"
            name="introduce">{{$user->introduce}}</textarea>
    </div>
    <div class="form-group mt-3">
        <input type="submit" class="form-control btn btn-primary btn-block" name="change_info"
            value="Cập nhật thông tin">
    </div>
</form>
