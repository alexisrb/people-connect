@extends('adminlte::page')

@section('title', 'People Connect')

@section('content')
   <div class="py-4">
        @livewire('admin.extra-hours.extra-hours-show', ['extraHour' => $extraHour], key($extraHour->id))
   </div>
@stop
