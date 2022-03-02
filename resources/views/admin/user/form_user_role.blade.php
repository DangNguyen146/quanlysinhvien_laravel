<form class="form-horizontal px-0" method="POST">
    {{ csrf_field() }}
    @foreach($roles as $role)
    @if(($role->name == 'teacher' || $role->name == 'supermoderator'))
    <div class="form-check custom-control custom-checkbox">
        <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="form-check-input custom-control-input"
            id="{{ $role->name }}" @if($user->hasRole($role->name)) checked
        @endif @if(!Auth::user()->hasRole('teacher')) disabled is-invalid @endif >
        <label class="custom-control-label text-danger form-check-label" for="{{ $role->name }}">{{$role->name}}</label>
    </div>
    @endif
    @endforeach
    <div class="form-group mt-1">
        @if(Auth::user()->hasRole('teacher'))
        <input type="submit" class="form-control btn btn-primary btn-block" name="change_super_role" value="Lưu">
        @else
        <input type="submit" class="form-control btn btn-danger btn-block" value="Không đủ quyền để thay đổi" disabled>
        @endif
    </div>
</form>
<form class="form-horizontal px-0 mt-3" method="POST">
    {{ csrf_field() }}
    @foreach($roles as $role)
    @if(!($role->name == 'teacher' || $role->name == 'supermoderator'))
    <div class="form-check custom-control custom-checkbox">
        <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="custom-control-input form-check-input"
            id="{{ $role->name }}" @if($user->hasRole($role->name))
        checked
        @endif>
        <label class="custom-control-label form-check-label" for="{{ $role->name }}">{{ $role->name }}</label>
    </div>
    @endif
    @endforeach
    <div class="form-group mt-1">
        <input type="submit" class="form-control btn btn-primary btn-block" name="change_role" value="Lưu">
    </div>
</form>