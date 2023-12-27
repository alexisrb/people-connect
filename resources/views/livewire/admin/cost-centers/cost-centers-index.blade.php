<div class="pt-4">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header bg-success">
            <h5 class="text-center my-2"><i class="fa-solid fa-list"></i> Todos los centros de costo <span class="badge badge-light"> {{$all_cost_centers}}</span></h5>
        </div>
        <div class="card-header">
            <div class="row">
                <div class="col-xl-8 col-lg-7 col-md-7 col-sm-7">
                    <div class="input-group my-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></div>
                        </div>
                        <input wire:model="search" class="form-control" placeholder="Ingrese el folio">
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                    <div class="form-group my-2" wire:model="order">
                        <select class="form-control" id="orderFormControlSelect">
                        <option value="1">Ordernar por más reciente</option>
                        <option value="2">Ordernar por más antiguo</option>
                        </select>
                    </div>
                </div>
                <div class="col-xl-1 col-lg-2 col-md-2 col-sm-2">
                    <a class="btn btn-success btn-block  my-2 @cannot('admin.cost_centers.create') disabled @endcannot" href="{{ route('admin.cost_centers.create') }}"><i class="fa-solid fa-plus"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body p-0 table-responsive">
            @if ($cost_centers->count())
                <table class="table table-hover text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Folio</th>
                            @can('admin.cost_centers.show')
                                <th></th>
                            @endcan
                            @can('admin.cost_centers.edit')
                                <th></th>
                            @endcan
                            @can('admin.cost_centers.destroy')
                                <th></th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cost_centers as $cost_center)
                            <tr>
                                <td>{{$cost_center->id}}</td>
                                <td>
                                    @isset($cost_center->folio)
                                        @can('admin.cost_centers.show')
                                            <a href="{{ route('admin.cost_centers.show', $cost_center) }}">{{$cost_center->folio}}</a>
                                        @else
                                            {{$cost_center->folio}}
                                        @endcan
                                    @else
                                        N/A
                                    @endisset
                                </td>
                                @can('admin.cost_centers.show')
                                    <td width="10px"><a class="btn btn-default btn-sm" href="{{route('admin.cost_centers.show', $cost_center)}}"><i class="fas fa-eye"></i></a></td>
                                @endcan
                                @can('admin.cost_centers.edit')
                                    <td width="10px"><a class="btn btn-default btn-sm" href="{{route('admin.cost_centers.edit', $cost_center)}}"><i class="fas fa-edit"></i></a></td>
                                @endcan
                                @can('admin.cost_centers.destroy')
                                    <td width="10px">
                                        <form action="{{ route('admin.cost_centers.destroy', $cost_center) }}" method="POST" class="alert-delete">
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
            {{$cost_centers->links()}}
        </div>
    </div>
</div>

@push('js')
    @if (session('eliminar') == 'ok')
        <script>
            Swal.fire(
            '¡Eliminado!',
            'El centro de costo se elimino con éxito.',
            'success'
            )
        </script>
    @endif

    <script>
        $('.alert-delete').submit(function (e) {
        e.preventDefault();
        Swal.fire({
        title: '¿Estas seguro?',
        text: "El centro de costo se eliminara definitivamente",
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