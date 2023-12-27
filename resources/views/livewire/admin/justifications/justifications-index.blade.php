<div class="pt-4">
      @if (session()->has('message'))
            <div class="alert alert-success">
            {{ session('message') }}
            </div>
      @endif
      <div class="card">
            <div class="card-header bg-success">
                  <h5 class="text-center my-2"><i class="fa-solid fa-list"></i> Todos las justificaciones <span class="badge badge-light"> {{$all_justifications}}</span></h5>
            </div>
            <div class="card-header">
                  <div class="row">
                        <div class="col-xl-3 col-lg-2 col-md-12 col-sm-12">
                              <a type="button" class="btn btn-secondary btn-block my-2" href="{{ route('admin.justify.export') }}"><i class="fa-solid fa-file-excel"></i> Justificaciones del día</a>
                        </div>
                  </div>
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
                              <a type="button" class="btn btn-secondary btn-block my-2" href="{{ route('admin.justificaciones.export', [$from, $to]) }}"><i class="fa-solid fa-file-excel"></i> Descargar justificaciones</a>
                        </div>
                  </div>
                  <div>
                        Justificación:
                        <span class="badge badge-success">Aprobada</span>
                        <span class="badge badge-danger">No aprobada</span>
                        <span class="badge badge-warning">En espera</span>
                  </div>
            </div>
            <div class="card-body p-0 table-responsive">
                  <table class="table table-hover text-center">
                        <thead>
                              <tr class="bg-light">
                                    <th>
                                          <span>Ordenar por:</span>
                                    </th>
                                    <th class="m-2" colspan="6">
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
                                    <th class="m-2">
                                          <select class="form-control form-control-sm text-center" id="compañia" wire:model="compañia">
                                                <option value="">-- Empresa / Compañia --</option>
                                                @foreach ($companies as $company)
                                                <option value="{{$company->id}}">{{$company->nombre_de_la_compañia}}</option>
                                                @endforeach
                                          </select>
                                    </th>
                                    <th class="m-2">
                                          <select class="form-control form-control-sm text-center" id="estatus" wire:model="estatus">
                                                <option value="">-- Estatus --</option>
                                                <option value="En espera">En espera</option>
                                                <option value="Aprobado">Aprobado</option>
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
                                    <th>Estatus de la justificación</th>
                              </tr>
                        </thead>
                        <tbody>
                              @if ($justifications->count())
                                    @foreach ($justifications as $justify)
                                          <tr>
                                                <td>{{$justify->id}}</td>
                                                <td>
                                                      @isset($justify->assistance->user_id)
                                                            @can('admin.users.show')
                                                                  <a href="{{ route('admin.users.show', $justify->assistance->user) }}">{{$justify->assistance->user->name}}</a>
                                                            @else
                                                                  {{$justify->assistance->user->name}}
                                                            @endcan
                                                      @else
                                                            N/A
                                                      @endisset
                                                </td>
                                                <td>
                                                      @if($justify->assistance->user->cost_center)
                                                            {{$justify->assistance->user->cost_center->folio}}
                                                      @else
                                                            <span class="text-danger">N/A</span>
                                                      @endif
                                                </td>
                                                <td>
                                                      @if($justify->assistance->user->areas->count())
                                                            {{$justify->assistance->user->areas->first()->área}}
                                                      @else
                                                            <span class="text-danger">N/A</span>
                                                      @endif
                                                </td>
                                                <td>
                                                      @isset($justify->assistance->user->company)
                                                            {{$justify->assistance->user->company->nombre_de_la_compañia}}
                                                      @else
                                                            <span class="text-danger">N/A</span>
                                                      @endisset
                                                </td>
                                                <td>
                                                      {{str_replace(' 00:00:00', '', $justify->assistance->created_at) }}
                                                </td>
                                                <td>
                                                @isset($justify->estatus)
                                                      @switch($justify->estatus)
                                                      @case("En espera")
                                                            <span class="text-warning">
                                                            @break
                                                      @case("Aprobado")
                                                            <span class="text-success">
                                                            @break
                                                      @default
                                                            <span class="text-danger">
                                                            @break
                                                      @endswitch
                                                @endisset
                                                      {{$justify->estatus}}</span>
                                                </td>
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
      </div>
</div>