<div class="pt-4">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    @if ($all_assistances != 0)
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Asistencias de empleados con fotografía <i class="fa-solid fa-image"></i></h5>
                        <hr>
                        
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-header bg-success">
            <h5 class="text-center my-2"><i class="fa-solid fa-list"></i> Todos las las asistencias <span class="badge badge-light"> {{$all_assistances}}</span></h5>
        </div>
        <div class="card-header">
            <div class="row">
                <div class="col-xl-9 col-lg-10 col-md-10 col-sm-10">
                    <div class="input-group my-2">
                        <p style="margin:6px">Desde: </p>
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></div>
                        </div>
                        <input type="date" wire:model="from" class="form-control">
                        <p style="margin:6px">Hasta: </p>
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></div>
                        </div>
                        <input type="date" wire:model="to" class="form-control">
                    </div>
                </div>
                <div class="col-xl-3 col-lg-2 col-md-12 col-sm-12">
                    <a type="button" class="btn btn-success btn-block my-2" href="{{ route('admin.assistances.export', [$from, $to]) }}"><i class="fa-solid fa-file-excel"></i> Assistencias del día</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-9 col-lg-10 col-md-10 col-sm-10">
                    <div class="input-group my-2">
                        <p style="margin:6px">Desde: </p>
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></div>
                        </div>
                        <input type="date" wire:model="from_ina" class="form-control">
                        <p style="margin:6px">Hasta: </p>
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></div>
                        </div>
                        <input type="date" wire:model="to_ina" class="form-control">
                    </div>
                </div>
                <div class="col-xl-3 col-lg-2 col-md-12 col-sm-12">
                    <a type="button" class="btn btn-danger btn-block my-2" href="{{ route('admin.inassistances.export', [$from_ina, $to_ina]) }}"><i class="fa-solid fa-file-excel"></i> Inasistencias del día</a>
                </div>
            </div>
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
                                    <option value="Asistió">Asistió</option>
                                    <option value="No asistió">No asistió</option>
                                </select>
                            </th>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Centro de costos</th>
                            <th>Área / Proyecto</th>
                            <th>Empresa / Compañia</th>
                            <th>Fecha</th>
                            <th>Estatus</th>
                            @can('admin.assistances.show')
                                <th></th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @if ($assistances->count())
                            @foreach ($assistances as $assistance)
                                <tr @isset($assistance->justify_attendance)
                                    class="
                                    @switch($assistance->justify_attendance)
                                        @case("No aprobado")
                                            bg-danger
                                            @break
                                        @case("Aprobado")
                                            bg-success
                                            @break
                                        @default
                                            bg-warning
                                    @endswitch
                                    "
                                @endisset>
                                    <td>
                                        @isset($assistance->user_id)
                                            @if($assistance->user != null)
                                                {{$assistance->user->id}}
                                            @else
                                                N/A
                                            @endif
                                        @else
                                            N/A
                                        @endisset
                                    </td>
                                    <td>
                                        @isset($assistance->user_id)
                                            @if($assistance->user != null)
                                                @can('admin.users.show')
                                                    <a href="{{ route('admin.users.show', $assistance->user) }}">{{$assistance->user->name}}</a>   
                                                @else
                                                    {{$assistance->user->name}}
                                                @endcan
                                            @else
                                                nada
                                            @endif
                                        @else
                                            N/A
                                        @endisset
                                    </td>
                                    <td>
                                        @isset($assistance->user->cost_center)
                                            {{$assistance->user->cost_center->folio}}
                                        @else
                                            <span class="text-danger">N/A</span>
                                        @endisset
                                    </td>
                                    <td>
                                        @isset($assistance->user->areas)
                                            @if($assistance->user->areas->first() != null)
                                                {{$assistance->user->areas->first()->área}}
                                            @else
                                                <span class="text-danger">N/A</span> 
                                            @endif
                                        @else
                                            <span class="text-danger">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @isset($assistance->user->company)
                                            {{$assistance->user->company->nombre_de_la_compañia}}
                                        @else
                                            <span class="text-danger">N/A</span>
                                        @endisset
                                    </td>
                                    <td>
                                        @isset($assistance->check)
                                            {{$assistance->check->fecha}}
                                        @endisset
                                    </td>
                                    <td>
                                        @if($assistance->justify_attendance)    
                                            {{$assistance->justify_attendance->tipo}}
                                        @else
                                            {{$assistance->asistencia}}
                                        @endif
                                    </td>
                                    @can('admin.assistances.show')
                                        <td width="10px"><a class="btn btn-default btn-sm" href="{{route('admin.assistances.show', $assistance)}}"><i class="fas fa-eye"></i></a></td>
                                    @endcan
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
            {{$assistances->links()}}
        </div>
    </div>
</div>
