@extends('adminlte::page')

@section('title', 'People Connect')

@section('content')
    <div class="py-4">
        @livewire('admin.administrative-records.administrative-records-edit', ['administrative_record' => $administrative_record], key($administrative_record->id))
    </div>
@stop

@section('css')

@stop

@section('js')

@stop
