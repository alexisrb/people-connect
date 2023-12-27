@extends('adminlte::page')

@section('title', 'People Connect')

@section('content')
    
    <div class="py-4">
        @livewire('admin.zktecos.zktecos-edit', ['zkteco' => $zkteco], key($zkteco->id))
    </div>
@stop

@section('css')

@stop

@section('js')

@stop
