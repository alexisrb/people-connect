@extends('adminlte::page')

@section('title', 'People Connect')

@section('content')
    <div class="py-4">
        @livewire('admin.admonitions.admonitions-show', ['admonition' => $admonition], key($admonition->id))
    </div>
@stop

@section('js')

@endsection

@section('css')

@endsection
