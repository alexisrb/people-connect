<div class="py-4">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb">
            @can('admin.default_schedules.index')
                <li class="breadcrumb-item"><a href="{{route('admin.default_schedules.index')}}">Todos los horarios predeterminados</a></li>
            @endcan
            <li class="breadcrumb-item active">Nuevo horario predeterminado </li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header bg-primary">
            <h5 class="text-center my-2">{{$default_schedule->nombre_del_horario}}</h5>
        </div>
        <div class="card-body">
            <form>
                <div class="g-3">
                    {{--Pincel--}}
                    <div class="row rounded border mb-4">
                        <div class="bg-gray rounded-left">
                            <div class="m-3">
                                <div class="my-auto"><i class="fas fa-pencil-alt"></i></div>
                            </div>
                        </div>
                        <div class="col m-2">
                            <div class="border-bottom">
                                <h5 class="py-1 text-center">Horario</h5>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label class="col-form-label">
                                        {{ __('Nombre del horario') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="nombre_del_horario" class="form-control" wire:model="default_schedule.nombre_del_horario" placeholder="Ingrese el nombre del horario predeterminado">
                                    @error('default_schedule.nombre_del_horario') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label class="col-form-label">
                                    {{ __('Tipo de jornada') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" id="tipo_jornada" wire:model="tipo_jornada">
                                    <option>Selecione un tipo de jornada</option>
                                    <option>Mixta</option>
                                    <option>Diurna</option>
                                </select>
                            </div> 
                            <div class="form-group col-12">
                                <label class="col-form-label">
                                    {{ __('Tipo de horas extras') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" id="tipo_horas" wire:model="tipo_horas">
                                    <option>Selecione un tipo de horas extras</option>
                                    <option>Extraordinarias</option>
                                    <option>Transportistas</option>
                                </select>
                            </div>
                            <div class="form-group col-12">
                                <label class="col-form-label">
                                    {{ __('Numero de jornadas') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="number" id="number_jornaulis" class="form-control" name="number_jornaulis" wire:model="number_jornaulis">
                                @error('number_jornaulis') <span class="text-danger error">{{ $message }}</span>@enderror
                            </div>
                            @if(!empty($number_jornaulis))
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table text-center border">
                                            <thead>
                                                <tr>
                                                    <th colspan="{{((int)$number_jornaulis)+1}}"><b>Horario</b></th>
                                                </tr>
                                                <tr>
                                                    <th class="bg-secondary"><i class="fa-solid fa-clock"></i></th>
                                                    @for($i=0; $i < $number_jornaulis; $i++)
                                                            <th class="border-left bg-secondary"> Jornada {{$i + 1}}</th>
                                                    @endfor
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="bg-light">Entrada</th>

                                                    @for($i=0; $i < $number_jornaulis; $i++)
                                                        <td class="border-left">
                                                            <div form-group>
                                                                <select class="w-100" id="day_entrada{$i}" name="day_entrada[]" required wire:model="day_entrada.jornada{{$i+1}}">
                                                                    <option value="">Seleccione el día</option>
                                                                    <option value="Lunes">Lunes</option>
                                                                    <option>Martes</option>
                                                                    <option>Miércoles</option>
                                                                    <option>Jueves</option>
                                                                    <option>Viernes</option>
                                                                    <option>Sábado</option>
                                                                    <option>Domingo</option>
                                                                </select>
                                                                @error('day_entrada.'.$i) <span class="text-danger error">{{ $message }}</span> @enderror
                                                                <input type="time" class="form-control border-0" id="entrada{{$i}}" required wire:model="hora_entrada.jornada{{$i+1}}">
                                                                @error('hora_entrada.'.$i) <span class="text-danger error">{{ $message }}</span> @enderror
                                                            </div>
                                                        </td>
                                                    @endfor
                                                </tr>
                                                <tr>
                                                    <tr>
                                                        <th scope="row" class="bg-light">Salida</th>
                                                        @for($i=0; $i < $number_jornaulis; $i++)
                                                            <td class="border-left">
                                                                <div form-group>
                                                                    <select class="w-100" id="day_salida{$i}" name="day_salida[]" required wire:model="day_salida.jornada{{$i+1}}">
                                                                            <option value="">Seleccione el día</option>
                                                                            <option>Lunes</option>
                                                                            <option>Martes</option>
                                                                            <option>Miércoles</option>
                                                                            <option>Jueves</option>
                                                                            <option>Viernes</option>
                                                                            <option>Sábado</option>
                                                                            <option>Domingo</option>
                                                                    </select>
                                                                    @error('day_salida.'.$i) <span class="text-danger error">{{ $message }}</span> @enderror
                                                                    <input type="time" class="form-control border-0" id="salida{{$i}}" required wire:model="hora_salida.jornada{{$i+1}}">
                                                                    @error('hora_salida.'.$i) <span class="text-danger error">{{ $message }}</span> @enderror
                                                                </div>
                                                            </td>
                                                        @endfor
                                                    </tr>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            @endif
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

    <link rel="stylesheet" href="/path/to/select2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

    <style>
    .select2 {
        width:100%!important;
    }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function () {
            $('#days').select2({
                theme: 'bootstrap4'
            });

            $('#days').on('change', function (e) {
                var data = $('#days').select2("val");
            @this.set('days', data);
            });
        });
    </script>
@endpush

