<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label required">Nama</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="place_of_birth" class="form-label required">Tempat Lahir</label>
            <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" required>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="birth_date" class="form-label required">Tanggal Lahir</label>
            <input type="date" class="form-control" id="birth_date" name="birth_date" required>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="gender" class="form-label required">Jenis Kelamin</label>
            <select class="form-select select2" id="gender" name="gender" required>
                @foreach (App\Enums\Gender::cases() as $gender)
                    <option value="{{ $gender->value }}">{{ $gender->label() }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="occupation_id" class="form-label required">Pekerjaan</label>
            <select class="form-select select2" id="occupation_id" name="occupation_id" required>
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="province_id" class="form-label required">Provinsi</label>
            <select class="form-select select2" id="province_id" name="province_id" required>
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="regency_id" class="form-label required">Kabupaten/Kota</label>
            <select class="form-select select2" id="regency_id" name="regency_id" required>
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="district_id" class="form-label required">Kecamatan</label>
            <select class="form-select select2" id="district_id" name="district_id" required>
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="village_id" class="form-label required">Kelurahan</label>
            <select class="form-select select2" id="village_id" name="village_id" required>
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="address" class="form-label required">Nama Jalan</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="rt" class="form-label required">RT</label>
            <input type="text" class="form-control" id="rt" name="rt" required>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="rw" class="form-label required">RW</label>
            <input type="text" class="form-control" id="rw" name="rw" required>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="deposit" class="form-label required">Nominal Setor</label>
            <input type="text" class="form-control" id="deposit_display" required>
            <input type="hidden" id="deposit" name="deposit">
        </div>
    </div>
</div>

@include('customers.script')
