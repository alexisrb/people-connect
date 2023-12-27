@extends('adminlte::page')

@section('title', 'People Connect')

@section('content')
<div class="py-4">
    @livewire('admin.devices.devices-edit', ['device' => $device], key($device->id))
</div>
   
@stop

@section('css')

@stop

@section('js')

@stop
