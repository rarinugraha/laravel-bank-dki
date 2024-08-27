<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="required">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="email" class="required">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}"
                required>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="password" class="required">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="password_confirmation" class="required">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                required>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="role" class="form-label required">Role</label>
            <select class="form-select select2" id="role" name="role" required>
                @foreach (App\Enums\Role::cases() as $role)
                    @if ($role !== App\Enums\Role::ADMIN)
                        <option value="{{ $role->value }}">{{ $role->label() }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="office_id" class="required">Office</label>
            <select class="form-select select2" id="office_id" name="office_id" required>
            </select>
        </div>
    </div>
</div>

@include('users.script')
