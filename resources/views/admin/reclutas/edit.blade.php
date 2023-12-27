@extends('adminlte::page')

@section('title', 'People Connect')

@section('content')
    @livewire('admin.reclutas.reclutas-edit', ['user' => $user], key($user->id))
@stop

@section('css')

@stop

@section('js')

@stop
