@extends('adminlte::page')

@section('title', 'People Connect')

@section('content')
    <div class="py-4">
        @livewire('admin.printers.printers-show', ['printer' => $printer], key($printer->id))
    </div>
@stop

@section('js')

@endsection

@section('css')

@endsection
