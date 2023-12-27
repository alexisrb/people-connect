<div class="pt-4">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    @if ($all_users != 0 && $usuariosActivos != 0)
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Empleados activos <i class="fa-solid fa-user"></i></h5>
                        <hr>
                        <p><b>{{$usuariosActivos}} empleados activos/{{$all_users}} empleados en sistema</b></p>
                        <div class="mx-5 progress" style="height: 3px;">
                            <div class="progress-bar" style="width: {{($usuariosActivos/$all_users)*100}}%"></div>
                        </div>
                        <p class="text-danger"><small>{{$usuariosInactivos}} empleados estan inactivos</small></p>
                        <p class="text-success"><small>{{$usuariosConFoto}} empleados con fotografica</small></p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-success">
            <h5 class="text-center my-2"><i class="fa-solid fa-list"></i> Todos los empleados <span class="badge badge-light"> {{$all_users}}</span></h5>
        </div>
        <div class="card-header">
            <div class="row">
                <div class="col-xl-11 col-lg-10 col-md-12 col-sm-12">
                    <a type="button" class="btn btn-secondary my-2" href="{{route('admin.usersCompleted.export')}}"><i class="fa-solid fa-file-excel"></i> Usuarios completos</a>
                    <a type="button" class="btn btn-secondary my-2" href="{{route('admin.usersWithCostCenter.export')}}"><i class="fa-solid fa-file-excel"></i> Usuarios con centro de costo</a>
                    <a type="button" class="btn btn-secondary my-2" href="{{route('admin.usersActives.export')}}"><i class="fa-solid fa-file-excel"></i> Usuarios activos</a>
                    <a type="button" class="btn btn-secondary my-2" href="{{route('admin.usersWithArea.export')}}"><i class="fa-solid fa-file-excel"></i> Usuarios con Area</a>
                    {{-- <a type="button" class="btn btn-secondary my-2" href="{{route('admin.usersWithoutImage.export')}}"><i class="fa-solid fa-file-excel"></i> Usuarios sin fotografía</a> --}}
                    {{-- <a type="button" class="btn btn-secondary my-2" href="{{route('admin.usersWithoutPuesto.export')}}"><i class="fa-solid fa-file-excel"></i> Usuarios sin puesto</a> --}}
                </div>
                <div class="col-xl-1 col-lg-2 col-md-12 col-sm-12">
                    <a class="btn btn-success btn-block my-2 @cannot('admin.users.create') disabled @endcannot" href="{{ route('admin.users.create') }}"><i class="fa-solid fa-plus"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body p-0 table-responsive">
                <table class="table table-hover text-center">
                    <thead>
                        <tr class="bg-light">
                            <th colspan="2">
                                <span>Ordenar por:</span>
                            </th>
                            <th class="m-2" colspan="21">
                                <select class="form-control form-control-sm text-center" wire:model="order">
                                    <option value="1">Ordenar por más reciente (# ID)</option>
                                    <option value="2">Ordenar por más antiguo (# ID)</option>
                                    <option value="3">Ordenar por número de empleado (Ascedente)</option>
                                    <option value="4">Ordenar por número de empleado (Decendente)</option>
                                    <option value="5">Ordenar por nombre (A-Z)</option>
                                    <option value="6">Ordenar por nombre (Z-A)</option>
                                </select>
                            </th>
                        </tr>
                        <tr class="bg-light">
                            <th>
                                <span>Filtrar por:</span>
                            </th>
                            <th class="m-2">
                                <input wire:model="searchNumero" class="form-control form-control-sm text-center" placeholder="No.">
                            </th>
                            <th class="m-2" colspan="2">
                                <input wire:model="searchName" class="form-control form-control-sm text-center" placeholder="Nombre">
                            </th>
                            <th class="m-2" colspan="2">
                                <input wire:model="searchEstatus" class="form-control form-control-sm text-center" placeholder="Estatus">
                            </th>
                            <th class="m-2" colspan="6">
                                <select class="form-control form-control-sm text-center" id="área" wire:model="área">
                                    <option value="">-- Área / Proyecto --</option>
                                    @foreach ($areas as $area)
                                        <option value="{{$area->id}}">{{$area->área}}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th class="m-2" colspan="8">
                                <select class="form-control form-control-sm text-center" id="cost_center" wire:model="cost_center">
                                    <option value="">-- Centro de costos --</option>
                                    @foreach ($cost_centers as $cost_center)
                                        <option value="{{$cost_center->id}}">{{$cost_center->folio}}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th class="m-2" colspan="5">
                                <select class="form-control form-control-sm text-center" id="compañia" wire:model="compañia">
                                    <option value="">-- Empresa / Compañia --</option>
                                    @foreach ($companies as $company)
                                        <option value="{{$company->id}}">{{$company->nombre_de_la_compañia}}</option>
                                    @endforeach
                                </select>
                            </th>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>No. de empleado</th>
                            <th>Nombre</th>
                            <th>Puesto</th>
                            <th colspan="4">Área / Proyecto</th>
                            <th>Empresa</th>
                            <th colspan="7">Centro de costos</th>
                            <th colspan="4">Estatus</th>
                            @can('admin.users.show')
                                <th></th>
                            @endcan
                            @can('admin.users.edit')
                                <th></th>
                            @endcan
                            @can('admin.users.destroy')
                                <th></th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->count())
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>
                                        @isset($user->número_de_empleado)
                                            {{$user->número_de_empleado}}
                                        @else
                                            <span class="text-danger">N/A</span>
                                        @endisset
                                    </td>
                                    <td>
                                        @isset($user->name)
                                            @can('admin.users.show')
                                                <a href="{{ route('admin.users.show', $user) }}">{{$user->name}}</a>
                                            @else
                                                {{$user->name}}
                                            @endcan
                                        @else
                                            <span class="text-danger">N/A</span>
                                        @endisset
                                        @if(!isset($user->image))
                                            -  <span class="text-danger"><i class="fa-solid fa-image"></i><small>* Sin fotografía</small></span>
                                        @endif
                                    </td>
                                    <td>
                                        @isset($user->puesto)
                                            {{$user->puesto}}
                                        @else
                                            <span class="text-danger">N/A</span>
                                        @endisset
                                    </td>
                                    <td colspan="4">
                                        @if($user->areas->count())
                                            {{$user->areas->first()->área}}
                                        @else
                                            <span class="text-danger">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @isset($user->company)
                                            {{$user->company->nombre_de_la_compañia}}
                                        @else
                                            <span class="text-danger">N/A</span>
                                        @endisset
                                    </td>
                                    <td colspan="7">
                                        @isset($user->cost_center)
                                            {{$user->cost_center->folio}}
                                        @else
                                            <span class="text-danger">N/A</span>
                                        @endisset
                                    </td>
                                    <td colspan="4">
                                        @isset($user->estatus)
                                            {{$user->estatus}}
                                        @else
                                            <span class="text-danger">N/A</span>
                                        @endisset
                                    </td>
                                    @can('admin.users.show')
                                        <td width="10px"><a class="btn btn-default btn-sm" href="{{route('admin.users.show', $user)}}"><i class="fas fa-eye"></i></a></td>
                                    @endcan
                                    @can('admin.users.edit')
                                        <td width="10px"><a class="btn btn-default btn-sm" href="{{route('admin.users.edit', $user)}}"><i class="fas fa-edit"></i></a></td>
                                    @endcan
                                    @can('admin.users.destroy')
                                        <td width="10px">
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="alert-delete">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="delete()"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </td>
                                    @endcan
                                    @can('admin.users.check')
                                        <td width="15px">
                                            <a type="button" class="btn btn-warning" href="{{ route('admin.users.check', $user) }}">Asistencia</a>
                                        </td>
                                        <td width = "20px">
                                            <a type="button" class="btn btn-danger" href="{{ route('admin.users.no_check', $user) }}">No asistencia</a>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        @else
                            <tr scope="row">
                                <td colspan="25">
                                    <p class="text-center text-danger pt-3"><strong>Sin registro</strong></p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
        </div>
        <div class="card-footer">
            {{$users->links()}}
        </div>
    </div>
</div>

@push('js')
    @if (session('eliminar') == 'ok')
        <script>
            Swal.fire(
            '¡Eliminado!',
            'El empleado se elimino con éxito.',
            'success'
            )
        </script>
    @endif

    <script>
        $('.alert-delete').submit(function (e) {
        e.preventDefault();
        Swal.fire({
        title: '¿Estas seguro?',
        text: "El empleado se eliminara definitivamente",
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
