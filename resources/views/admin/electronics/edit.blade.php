@extends('adminlte::page')

@section('title', 'People Connect')

@section('content')
    <div class="py-4">
        @livewire('admin.electronics.electronics-edit', ['electronic' => $electronic], key($electronic->id))
    </div>
@stop

@section('css')

@stop

@section('js')

@stop
