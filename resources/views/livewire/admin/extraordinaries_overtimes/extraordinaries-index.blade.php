<div class="pt-4">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header bg-success">
            <h5 class="text-center my-2"><i class="fa-solid fa-list"></i> Todas las horas extra extraordinarias</h5>
        </div>
        <div class="card-header">
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
                    <a class="btn btn-success btn-block  my-2" href="{{ route('admin.extraordinary.create') }}"><i class="fa-solid fa-plus"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body p-0 table-responsive">
                <table class="table table-hover text-center">
                    <thead>
                        <tr class="bg-light">
                            <th class="m-2">
                                <input wire:model="searchNumero" class="form-control form-control-sm text-center" placeholder="No.">
                            </th>
                            <th class="m-2" colspan="2">
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
                            <th class="m-2" colspan="2">
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
                            <th>Horas</th>
                            <th>Fecha y hora</th>
                            <th>Usuario</th>
                            <th>Centro de costos</th>
                            <th>Área / Proyecto</th>
                            <th>Empresa / Compañia</th>
                            <th>Estatus</th>
                            
                                <th></th>
                            
                                <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($all_extraordinaries->count())
                            @foreach($all_extraordinaries as $extraordinary)
                                <tr>
                                    <td>{{$extraordinary->id}}</td>
                                    <td>
                                        @if($extraordinary->hours != null)
                                            {{$extraordinary->hours}}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{str_replace('T',' ' ,$extraordinary->fecha_hora)}}</td>
                                    <td>
                                        @isset($extraordinary->user)
                                            @can('admin.users.show')
                                                <a href="{{ route('admin.users.show', $extraordinary->user) }}">{{$extraordinary->user->name}}</a>
                                            @else
                                                {{$extraordinary->user->name}}
                                            @endcan
                                        @else
                                            N/A
                                        @endisset
                                    </td>
                                    <td> 
                                        @if($extraordinary->user->cost_center)
                                            {{$extraordinary->user->cost_center->folio}}
                                        @else
                                            <span class="text-danger">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($extraordinary->user->areas->count())
                                            {{$extraordinary->user->areas->first()->área}}
                                        @else
                                            <span class="text-danger">N/A</span>
                                        @endif 
                                    </td>
                                    <td> 
                                        @isset($extraordinary->user->company)
                                            {{$extraordinary->user->company->nombre_de_la_compañia}}
                                        @else
                                            <span class="text-danger">N/A</span>
                                        @endisset
                                    </td>
                                    <td>{{$extraordinary->estatus}}</td>
                                    <td width="10px"><a class="btn btn-default btn-sm" href="{{route('admin.extraordinary.aprove', $extraordinary->id)}}" style="color: green;">Autorizar</a></td>
                                    <td width="10px"><a class="btn btn-default btn-sm" href="{{route('admin.extraordinary.disaprove', $extraordinary->id)}}" style="color: red;">No autorizar</a></td>
                                </tr>
                            @endforeach
                        @endif
                        <tr scope="row">
                              <td colspan="11">
                              <p class="text-center text-danger pt-3"><strong>Sin registro</strong></p>
                              </td>
                        </tr>
                    </tbody>
                </table>
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
