@extends('adminlte::page')

@section('title', 'People Connect')

@section('content')
    @livewire('admin.vacations.vacations-edit', ['vacation' => $vacation], key($vacation->id))
@stop

@section('css')

@stop

@section('js')

@stop
