@extends('adminlte::page')

@section('title', 'People Connect')

@section('content')
    <div class="py-4">
        @livewire('admin.default-shedules.default-schedule-show', ['default_schedule' => $default_schedule], key($default_schedule->id))
    </div>
@stop

@section('js')

@endsection

@section('css')

@endsection
