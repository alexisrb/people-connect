@extends('adminlte::page')

@section('title', 'People Connect')

@section('content')
    <div class="py-4">
        @livewire('admin.phones.phones-show', ['phone' => $phone], key($phone->id))
    </div>
@stop

@section('js')

@endsection

@section('css')

@endsection
