<div class="py-4">
      <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
            @can('admin.extraordinary.index')
                  <li class="breadcrumb-item"><a href="{{route('admin.extraordinary.index')}}">Todas las horas extras extraordinarias</a></li>
            @endcan
            <li class="breadcrumb-item active">Registrar horas extras extraordinarias</li>
            </ol>
      </nav>
      <div class="card">
            <div class="card-header bg-primary">
                  <h5 class="text-center my-2">Horas extra extraordinarias</h5>
            </div>
            <div class="card-body">
                  <form>
                        <div class="g-3">
                              <div class="row rounded border">
                                    <div class="bg-gray rounded-left">
                                          <div class="m-3">
                                                <div class="my-auto"><i class="fas fa-pencil-alt"></i></div>
                                          </div>
                                    </div>
                                    <div class="col m-2">
                                          <div class="border-bottom">
                                                <h5 class="py-1 text-center">Hora extra extraordinaria</h5>
                                          </div>
                                          <div class="row">
                                                <div class="form-group col-12">
                                                      <label class="col-form-label">
                                                            {{__('Horas extras')}}
                                                            <span class="text-danger">*</span>
                                                      </label>
                                                      <input type="number" id="hours" class="form-control" max="3" wire:model="hours">
                                                      @error('hours') <span class="text-danger error">{{ $message }}</span>@enderror
                                                </div>
                                                <div class="form-group col-12">
                                                      <label class="col-form-label">
                                                            {{__('Fecha y hora')}}
                                                            <span class="text-danger">*</span>
                                                      </label>
                                                      <input type="datetime-local" id="fecha_hora" class="form-control" wire:model="fecha_hora">
                                                      @error('fecha') <span class="text-danger error">{{ $message }}</span>@enderror
                                                </div>
                                                <div class="form-group col-12">
                                                      <div wire:ignore>
                                                            <label class="col-form-label">
                                                                  {{ __('Usuario') }}
                                                                  <small>(Con derecho a horas extras)</small>
                                                                  <span class="text-danger">*</span>
                                                            </label>
                                                            <select class="form-control" id="users">
                                                                  <option value="">Selecciona una opción</option>
                                                                  @foreach($users as $user)
                                                                        <option value="{{ $user->id}}">{{ $user->name }}, {{$user->número_de_empleado}}</option>
                                                                  @endforeach
                                                            </select>
                                                      </div>
                                                      @error('user') <span class="text-danger error">{{ $message }}</span>@enderror
                                                </div>
                                                <div class="form-group col-12">
                                                      <div wire:ignore>
                                                            <label class="col-form-label">
                                                                  {{ __('Autorizacion de jefe directo') }}
                                                                  <span class="text-danger">*</span>
                                                            </label> {{Auth()->user()->name}}
                                                            
                                                      </div>
                                                      @error('user') <span class="text-danger error">{{ $message }}</span>@enderror
                                                </div>
                                                <div class="form-group col-12">
                                                      <label class="col-form-label">
                                                            {{ __('Estatus') }}
                                                            <span class="text-danger">*</span>
                                                      </label>
                                                      <select class="form-control" id="journalis_estatus" wire:model="journalis_estatus">
                                                            <option value="">Seleccione el día</option>
                                                            <option>Autorizadas</option>
                                                            <option>Pendiente</option> 
                                                      </select>
                                                </div> 
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </form>
            </div>
            <div class="card-footer">
                  <div class="text-center">
                        <button type="button" wire:loading.attr="disabled" wire:click.prevent="save()" wire:target="save" class="btn btn-success">Guardar</button>
                  </div>
            </div>
      </div>
</div>

@push('css')
<style>
      .select2 {
            width:100%!important;
      }
</style>
@endpush


@push('js')
      <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>


      <script>
            $(document).ready(function () {

                  $('#users').select2({
                        theme: 'bootstrap4'
                  });

                  $('#users').on('change', function (e) {
                        var data = $('#users').select2("val");
                        @this.set('user', data);
                  });

                  $('#users_boss').select2({
                        theme: 'bootstrap4'
                  });

                  $('#users_boss').on('change', function (e) {
                        var data = $('#users_boss').select2("val");
                        @this.set('users_boss', data);
                  });

                  $('#number_jornaulis').on('change', function (e) {
                        var data = $('#number_jornaulis').val();
                              @this.set('number_jornaulis', data);
                        });
                  });
      </script>
@endpush
