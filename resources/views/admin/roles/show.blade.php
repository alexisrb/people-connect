@extends('adminlte::page')

@section('title', 'People Connect')

@section('content')
    <div class="py-4">
        @livewire('admin.roles.roles-show', ['role' => $role], key($role->id))
    </div>
@stop
