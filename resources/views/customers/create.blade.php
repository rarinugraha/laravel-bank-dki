@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Pembukaan Rekening Nasabah</div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('customers.store') }}" method="POST">
                    @csrf
                    @include('customers.form')
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
