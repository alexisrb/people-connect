@extends('adminlte::page')

@section('title', 'People Connect')

@section('content')
    @livewire('admin.safeties.safeties-edit', ['safety' => $safety], key($safety->id))
@stop

@section('css')

@stop

@section('js')

@stop
