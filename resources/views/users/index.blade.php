@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-3">
            <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah Pengguna</a>
        </div>
        <div class="card">
            <div class="card-header">Pengguna</div>
            <div class="card-body">
                {{ $html->table() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {!! $html->scripts() !!}
@endpush
