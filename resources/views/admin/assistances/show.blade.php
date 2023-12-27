@extends('adminlte::page')

@section('title', 'People Connect')

@section('content')
    <div class="py-4">
        @livewire('admin.assistances.assistances-show', ['assistance' => $assistance], key($assistance->id))
    </div>
@stop

@section('css')

@endsection
