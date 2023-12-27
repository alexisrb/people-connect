@extends('adminlte::page')

@section('title', 'People Connect')

@section('content')
    <div class="py-4">
        @livewire('admin.cost-centers.cost-centers-show', ['cost_center' => $cost_center], key($cost_center->id))
    </div>
@stop
