<div class="pt-4">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header bg-success">
            <h5 class="text-center my-2"><i class="fa-solid fa-list"></i> Todas las horas extras <span class="badge badge-light"> {{$all_extraHours}}</span></h5>
        </div>
        <div class="card-header">
            <div class="row">
                <div class="col-xl-11 col-lg-10 col-md-12 col-sm-12">
                    <a type="button" class="btn btn-secondary my-2" href="{{route('admin.extraHours.export')}}"><i class="fa-solid fa-file-excel"></i> Calculo de horas extras del día</a>
                    <a type="button" class="btn btn-secondary my-2" href="{{route('admin.extraHours.export')}}"><i class="fa-solid fa-file-excel"></i> Horas extras autorizadas</a>
                    <a type="button" class="btn btn-secondary my-2" href="{{route('admin.extraHours.export')}}"><i class="fa-solid fa-file-excel"></i> Horas etras por autorizar</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-8 col-lg-7 col-md-7 col-sm-7">
                    <div class="input-group my-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></div>
                        </div>
                        <input type="date" wire:model="date" class="form-control">
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
                    <a class="btn btn-success btn-block  my-2 @cannot('admin.extra_hours.create') disabled @endcannot" href="{{ route('admin.extra_hours.create') }}"><i class="fa-solid fa-plus"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body p-0 table-responsive">
                <table class="table table-hover text-center">
                    <thead>
                        <tr class="bg-light">
                            <th>
                                <span>Filtrar por:</span>
                            </th>
                            <th class="m-2">
                                <input wire:model="searchNumero" class="form-control form-control-sm text-center" placeholder="No.">
                            </th>
                            <th class="m-2">
                                <input wire:model="searchName" class="form-control form-control-sm text-center" placeholder="Nombre">
                            </th>
                            <th class="m-2" colspan="2">
                                <select class="form-control form-control-sm text-center" id="área" wire:model="área">
                                    <option value="">-- Área / Proyecto --</option>
                                    @foreach ($areas as $area)
                                        <option value="{{$area->id}}">{{$area->área}}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th class="m-2" colspan="2">
                                <select class="form-control form-control-sm text-center" id="cost_center" wire:model="cost_center">
                                    <option value="">-- Centro de costos --</option>
                                    @foreach ($cost_centers as $cost_center)
                                        <option value="{{$cost_center->id}}">{{$cost_center->folio}}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th class="m-2">
                                <select class="form-control form-control-sm text-center" id="compañia" wire:model="compañia">
                                    <option value="">-- Empresa / Compañia --</option>
                                    @foreach ($companies as $company)
                                        <option value="{{$company->id}}">{{$company->nombre_de_la_compañia}}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th class="m-2" colspan="3">
                                <select class="form-control form-control-sm text-center" id="estatus" wire:model="estatus">
                                    <option value="">-- Estatus --</option>
                                    <option value="Autorizadas">Autorizadas</option>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="No aprobado">No aprobado</option>
                                </select>
                            </th>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>Horas extras calculadas</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Centro de costos</th>
                            <th>Área / Proyecto</th>
                            <th>Empresa / Compañia</th>
                            <th>Estatus</th>
                            @can('admin.extra_hours.show')
                                <th></th>
                            @endcan
                            @can('admin.extra_hours.edit')
                                <th></th>
                            @endcan
                            @can('admin.extra_hours.destroy')
                                <th></th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @if ($extraHours->count())
                        @foreach ($extraHours as $extraHour)
                            <tr @if($extraHour->estatus != 'Aprobado') class="table-danger" @endif>
                                <td>{{$extraHour->id}}</td>
                                <td>
                                    @isset($extraHour->horas)
                                        {{$extraHour->horas}}
                                    @else
                                        N/A
                                    @endisset
                                </td>
                                <td>
                                    @isset($extraHour->fecha)
                                        {{$extraHour->fecha->format('d/m/Y')}}
                                    @else
                                        N/A
                                    @endisset
                                </td>
                                <td>
                                    @isset($extraHour->user)
                                        @can('admin.users.show')
                                            <a href="{{ route('admin.users.show', $extraHour->user) }}">{{$extraHour->user->name}}</a>
                                        @else
                                            {{$extraHour->user->name}}
                                        @endcan
                                    @else
                                        N/A
                                    @endisset
                                </td>
                                <td>
                                    @if($extraHour->user->cost_center)
                                        {{$extraHour->user->cost_center->folio}}
                                    @else
                                        <span class="text-danger">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($extraHour->user->areas->count())
                                        {{$extraHour->user->areas->first()->área}}
                                    @else
                                        <span class="text-danger">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @isset($extraHour->user->company)
                                        {{$extraHour->user->company->nombre_de_la_compañia}}
                                    @else
                                        <span class="text-danger">N/A</span>
                                    @endisset
                                </td>
                                <td>
                                    {{$extraHour->estatus}}
                                </td>
                                @can('admin.extra_hours.show')
                                    <td width="10px"><a class="btn btn-default btn-sm" href="{{route('admin.extra_hours.show', $extraHour)}}"><i class="fas fa-eye"></i></a></td>
                                @endcan
                                @can('admin.extra_hours.edit')
                                    <td width="10px"><a class="btn btn-default btn-sm" href="{{route('admin.extra_hours.edit', $extraHour)}}"><i class="fas fa-edit"></i></a></td>
                                @endcan
                                @can('admin.extra_hours.destroy')
                                    <td width="10px">
                                        <form action="{{ route('admin.extra_hours.destroy', $extraHour) }}" method="POST" class="alert-delete">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="delete()"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                        @else
                            <tr scope="row">
                                <td colspan="11">
                                    <p class="text-center text-danger pt-3"><strong>Sin registro</strong></p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
        </div>
        <div class="card-footer">
            {{$extraHours->links()}}
        </div>
    </div>
</div>

@push('js')
    @if (session('eliminar') == 'ok')
        <script>
            Swal.fire(
            '¡Eliminado!',
            'La hora extra se elimino con éxito.',
            'success'
            )
        </script>
    @endif

    <script>
        $('.alert-delete').submit(function (e) {
        e.preventDefault();
        Swal.fire({
        title: '¿Estas seguro?',
        text: "La hora extra se eliminara definitivamente",
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
