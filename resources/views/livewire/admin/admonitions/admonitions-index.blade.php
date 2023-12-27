<div class="pt-4">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header bg-success">
            <h5 class="text-center my-2"><i class="fa-solid fa-list"></i> Todas las amonestaciones <span class="badge badge-light"> {{$all_admonitions}}</span></h5>
        </div>
        <div class="card-header">
            <div class="row">
                <div class="col-xl-11 col-lg-10 col-md-10 col-sm-10">
                    <div class="form-group my-2" wire:model="order">
                        <select class="form-control" id="orderFormControlSelect">
                        <option value="1">Ordernar por más reciente</option>
                        <option value="2">Ordernar por más antiguo</option>
                        </select>
                    </div>
                </div>
                <div class="col-xl-1 col-lg-2 col-md-2 col-sm-2">
                    <a class="btn btn-success btn-block  my-2 @cannot('admin.admonitions.create') disabled @endcannot" href="{{ route('admin.admonitions.create') }}"><i class="fa-solid fa-plus"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body p-0 table-responsive">
            @if ($admonitions->count())
                <table class="table table-hover text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Amonestado</th>
                            <th>Fecha de la insidencia</th>
                            <th>Gravedad</th>
                            @can('admin.admonitions.show')
                                <th></th>
                            @endcan
                            @can('admin.admonitions.edit')
                                <th></th>
                            @endcan
                            @can('admin.admonitions.destroy')
                                <th></th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admonitions as $admonition)
                            <tr>
                                <td>{{$admonition->id}}</td>
                                <td>
                                    @isset($admonition->amonestado->name)
                                        @can('admin.users.show')
                                            <a href="{{ route('admin.users.show', $admonition->amonestado) }}">{{$admonition->amonestado->name}}</a>
                                        @else
                                            {{$admonition->amonestado->name}}
                                        @endcan
                                    @else
                                        N/A
                                    @endisset
                                </td>
                                <td>
                                    @isset($admonition->fecha_de_la_incidencia)
                                        {{$admonition->fecha_de_la_incidencia->format('d/m/Y')}}
                                    @else
                                        N/A
                                    @endisset
                                </td>
                                <td>
                                    @isset($admonition->gravedad)
                                        {{$admonition->gravedad}}
                                    @else
                                        N/A
                                    @endisset
                                </td>
                                @can('admin.admonitions.show')
                                    <td width="10px"><a class="btn btn-default btn-sm" href="{{route('admin.admonitions.show', $admonition)}}"><i class="fas fa-eye"></i></a></td>
                                @endcan
                                @can('admin.admonitions.edit')
                                    <td width="10px"><a class="btn btn-default btn-sm" href="{{route('admin.admonitions.edit', $admonition)}}"><i class="fas fa-edit"></i></a></td>
                                @endcan
                                @can('admin.admonitions.destroy')
                                    <td width="10px">
                                        <form action="{{ route('admin.admonitions.destroy', $admonition) }}" method="POST" class="alert-delete">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="delete()"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="my-5">
                    <p class="text-center text-danger"><strong>Sin registro</strong></p>
                </div>
            @endif
        </div>
        <div class="card-footer">
            {{$admonitions->links()}}
        </div>
    </div>
</div>

@push('js')
    @if (session('eliminar') == 'ok')
        <script>
            Swal.fire(
            '¡Eliminado!',
            'La amonestación se elimino con éxito.',
            'success'
            )
        </script>
    @endif

    <script>
        $('.alert-delete').submit(function (e) {
        e.preventDefault();
        Swal.fire({
        title: '¿Estas seguro?',
        text: "La amonestación se eliminara definitivamente",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Eliminar!',
        cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });
    </script>
@endpush