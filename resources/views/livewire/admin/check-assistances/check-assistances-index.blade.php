<div class="pt-4">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header bg-success">
            <h5 class="text-center my-2"><i class="fa-solid fa-check-to-slot"></i> Todos los pase de lista <span class="badge badge-light"> {{$check->count()}}</span></h5>
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover text-center">
                <thead>
                    <tr class="bg-light">
                        <th>
                            <span>Ordenar por:</span>
                        </th>
                        <th class="m-2" colspan="7">
                            <select class="form-control form-control-sm text-center" wire:model="order">
                                <option value="1">Ordenar por más reciente (# ID)</option>
                                <option value="2">Ordenar por más antiguo (# ID)</option>
                            </select>
                        </th>
                    </tr>
                    <tr class="bg-light">
                        <th>
                            <span>Filtrar por:</span>
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
                            <select class="form-control form-control-sm text-center" id="compañia" wire:model="compañia">
                                <option value="">-- Empresa / Compañia --</option>
                                @foreach ($companies as $company)
                                    <option value="{{$company->id}}">{{$company->nombre_de_la_compañia}}</option>
                                @endforeach
                            </select>
                        </th>
                    </tr>
                    <tr>
                        <th># de Empleado</th>
                        <th>Nombre</th>
                        <th>Área / Proyecto</th>
                        <th>Empresa / Compañia</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estatus</th>
                        @can('admin.assistances.show')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @if($check->count())
                        @foreach ($check as $check_assitance)
                            <tr>
                                <td>
                                    {{$check_assitance->user->número_de_empleado}}
                                </td>
                                <td>
                                    @isset($check_assitance->user_id)
                                        @if($check_assitance->user != null)
                                            @can('admin.users.show')
                                                <a href="{{ route('admin.users.show', $check_assitance->user) }}">{{$check_assitance->user->name}}</a>   
                                            @else
                                                {{$check_assitance->user->name}}
                                            @endcan
                                        @else
                                            nada
                                        @endif
                                    @else
                                        N/A
                                    @endisset
                                </td>
                                <td>
                                    @isset($check_assitance->user->cost_center)
                                        {{$check_assitance->user->cost_center->folio}}
                                    @else
                                        <span class="text-danger">N/A</span>
                                    @endisset
                                </td>
                                <td>
                                    @isset($check_assitance->user->areas)
                                        @if($check_assitance->user->areas->first() != null)
                                            {{$check_assitance->user->areas->first()->área}}
                                        @else
                                            <span class="text-danger">N/A</span> 
                                        @endif
                                    @else
                                        <span class="text-danger">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    {{$check_assitance->fecha->format('d/m/Y')}}
                                </td>
                                <td>
                                    {{$check_assitance->hora}}
                                </td>
                                <td>
                                    {{$check_assitance->estatus}}
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                    @else
                        <tr scope="row">
                            <td colspan="8">
                                <p class="text-center text-danger pt-3"><strong>Sin registro</strong></p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{$check->links()}}
        </div>
    </div> 
</div>