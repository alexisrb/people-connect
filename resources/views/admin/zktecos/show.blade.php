@extends('adminlte::page')

@section('title', 'People Connect')

@section('content')
    <div class="py-4">
        @livewire('admin.zktecos.zktecos-show', ['zkteco' => $zkteco], key($zkteco->id))
    </div>
@stop

@section('js')

@endsection

@section('css')

@endsection
