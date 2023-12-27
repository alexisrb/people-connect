@extends('adminlte::page')

@section('title', 'People Connect')

@section('content')
    
    <div class="py-4">
        @livewire('admin.areas.areas-edit', ['area' => $area], key($area->id))
    </div>
@stop

@section('css')

@stop

@section('js')

@stop
