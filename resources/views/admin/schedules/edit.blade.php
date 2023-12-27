@extends('adminlte::page')

@section('title', 'People Connect')

@section('content')
    @livewire('admin.schedules.schedules-edit', ['schedule' => $schedule], key($schedule->id))
@stop

@section('css')

@stop

@section('js')

@stop
