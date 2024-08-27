@extends('layouts.app')

@section('content')
    <div class="container">
        @if (auth()->user()->role === App\Enums\Role::CS->value)
            <div class="mb-3">
                <a href="{{ route('customers.create') }}" class="btn btn-primary">Calon Nasabah</a>
            </div>
        @endif
        <div class="card">
            <div class="card-header">Data Nasabah</div>
            <div class="card-body">
                {{ $html->table() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {!! $html->scripts() !!}
@endpush
