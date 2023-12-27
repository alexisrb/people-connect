<div class="py-4">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb">
            @can('admin.users.index')
                <li class="breadcrumb-item"><a href="{{route('admin.users.index')}}">Todos los empleados</a></li>
            @endcan
            <li class="breadcrumb-item active">Nuevo empleado</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header bg-primary">
            <h5 class="text-center my-2">{{$name}}</h5>
        </div>
        <div class="card-body">
            <form>
                <div class="g-3">
                    {{--Foto--}}
                    <div class="row rounded border  mb-3">
                        <div class="bg-gray rounded-left">
                            <div class="m-3">
                                <div class="my-auto"><i class="fas fa-image"></i></div>
                            </div>
                        </div>
                        <div class="col m-2">
                            <div class="border-bottom">
                                <h5 class="py-1 text-center">Foto</h5>
                            </div>
                            <div class="custom-file mt-3 pt-3">
                                <input type="file" class="custom-file-input" lang="es" wire:model="foto" accept="image/*">
                                <label class="custom-file-label" for="customFileLang">Selecciona una foto</label>
                                @error('foto') <span class="text-danger error">{{ $message }}</span>@enderror
                            </div>
                            <div>
                                {{-- <div wire:loading wire:target="foto">
                                    <button class="btn btn-white mt-3" type="button" disabled>
                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                        Cargando...
                                    </button>
                                </div> --}}
                                {{-- <div class="pt-3">
                                    @if($foto)
                                        <img class="img-fluid rounded" style="display: block; margin-left: auto; margin-right: auto;" src="{{$foto->temporaryurl()}}">
                                    @endif
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    {{--Pincel--}}
                    <div class="row rounded border mb-4">
                        <div class="bg-gray rounded-left">
                            <div class="m-3">
                                <div class="my-auto"><i class="fas fa-pencil-alt"></i></div>
                            </div>
                        </div>
                        <div class="col m-2">
                            <div class="border-bottom">
                                <h5 class="py-1 text-center">Datos del usuario</h5>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label class="col-form-label">
                                        {{ __('Nombre completo') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="name" class="form-control" wire:model="name" placeholder="Ingrese el nombre">
                                    @error('name') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12">
                                    <label class="col-form-label">
                                        {{ __('Fecha de nacimiento') }}
                                    </label>
                                    <input type="date" id="fecha_de_nacimiento" class="form-control" wire:model="fecha_de_nacimiento" placeholder="Ingrese la fecha de nacimiento">
                                    @error('fecha_de_nacimiento') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12">
                                    <label class="col-form-label">
                                        {{ __('Correo') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="correo" class="form-control" wire:model="email" placeholder="Ingrese el correo">
                                    @error('email') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12">
                                    <label class="col-form-label">
                                        {{ __('Whatsapp') }}
                                    </label>
                                    <div class="row">
                                        <div class="col-2">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text" id="basic-addon1">+</span>
                                                </div>
                                                <input type="number" id="código_del_país" class="form-control" wire:model="código_del_país" placeholder="Código del país">
                                                @error('código_del_país') <span class="text-danger error">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-10">
                                            <input type="number" id="número_de_teléfono" class="form-control" wire:model="número_de_teléfono" placeholder="Número de teléfono">
                                            @error('número_de_teléfono') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label class="col-form-label">
                                        {{ __('CURP') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="curp" class="form-control" wire:model="curp" placeholder="Ingrese el CURP" oninput="this.value = this.value.toUpperCase()">
                                    @error('curp') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label class="col-form-label">
                                        {{ __('Número de inscripción al IMSS') }}
                                    </label>
                                    <input type="text" id="número_de_inscripción_al_imss" class="form-control" wire:model="número_de_inscripción_al_imss" placeholder="Ingrese el número de inscripción al IMSS">
                                    @error('número_de_inscripción_al_imss') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label class="col-form-label">
                                        {{ __('RFC') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="rfc" class="form-control" wire:model="rfc" placeholder="Ingrese el RFC" oninput="this.value = this.value.toUpperCase()">
                                    @error('rfc') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12">
                                    <label class="col-form-label">
                                        {{ __('Número del infonavit') }}
                                    </label>
                                    <input type="text" id="número_del_infonavit" class="form-control" wire:model="número_del_infonavit" placeholder="Ingrese el número del infonavit">
                                    @error('número_del_infonavit') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--Trabajo--}}
                    <div class="row rounded border mb-4">
                        <div class="bg-gray rounded-left">
                            <div class="m-3">
                                <div class="my-auto"><i class="fa-solid fa-briefcase"></i></div>
                            </div>
                        </div>
                        <div class="col m-2">
                            <div class="border-bottom">
                                <h5 class="py-1 text-center">Datos del trabajo</h5>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label class="col-form-label">
                                        {{ __('Número de empleado') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" id="número_de_empleado" class="form-control" wire:model="número_de_empleado" placeholder="Ingrese el número de empleado">
                                    @error('número_de_empleado') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12">
                                    <label class="col-form-label">
                                        {{ __('Fecha de ingreso') }}
                                    </label>
                                    <input type="date" id="fecha_de_ingreso" class="form-control" wire:model="fecha_de_ingreso" placeholder="Ingrese la fecha de ingreso">
                                    @error('fecha_de_ingreso') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label class="col-form-label">
                                        {{ __('Puesto') }}
                                    </label>
                                    <input type="text" id="puesto" class="form-control" wire:model="puesto" placeholder="Ingrese el puesto">
                                    @error('puesto') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <div>
                                        <label class="col-form-label">
                                            {{ __('Nivel de Puesto') }}
                                        </label>
                                        <select class="form-control" id="tipo_de_puesto" wire:model="tipo_de_puesto">
                                            <option value="">Selecciona una opción</option>
                                            <option value="Dirección">Dirección</option>
                                            <option value="Gerencia">Gerencia</option>
                                            <option value="Jefatura">Jefatura</option>
                                            <option value="Administrativo">Administrativo</option>
                                            <option value="Rh">RH</option>
                                            <option value="Administrativo_obras">Administrativo Obras</option>
                                            <option value="Operacion">Operacion</option>
                                        </select>
                                    </div>
                                    @error('tipo_de_puesto') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12">
                                    <div wire:ignore>
                                        <label class="col-form-label">
                                            {{ __('Empresa / Compañia') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control" id="companies" wire:model="company">
                                            <option value="">Selecciona una opción</option>
                                            @foreach($companies as $company)
                                                <option value="{{ $company->id}}">{{ $company->nombre_de_la_compañia }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('company') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                @if(!is_null($cost_centers))
                                    <div class="form-group col-12">
                                        <div>
                                            <label class="col-form-label">
                                                {{ __('Centro de costos') }}
                                            </label>
                                            <select class="form-control" id="cost_centers" wire:model="cost_center">
                                                <option value="">Selecciona una opción</option>
                                                @foreach($cost_centers as $cost_center)
                                                    <option value="{{ $cost_center->id}}">{{ $cost_center->folio }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('cost_center') <span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>
                                @endif
                                <div class="form-group col-12">
                                    <div wire:ignore>
                                        <label class="col-form-label">
                                            {{ __('Área / Proyecto') }}
                                        </label>
                                        <select class="form-control" id="área" wire:model="área">
                                            <option value="">Selecciona una opción</option>
                                            @foreach($areas as $area)
                                                <option value="{{ $area->id}}">{{ $area->área }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('área') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12">
                                    <div wire:ignore>
                                        <label class="col-form-label">
                                            {{ __('Jefe Directo') }}
                                        </label>
                                        <select class="form-control" id="users" wire:model="encargado">
                                            <option value="">Selecciona una opción</option>
                                            @foreach($users as $encargado)
                                                <option value="{{ $encargado->id}}">{{ $encargado->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('encargado') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="border-bottom">
                                {{-- TRABAJO P2/ CONFIGURACIÓN --}}
                                <h5 class="py-1 text-center">Configuración de Capital Humano</h5>
                            </div>
                            <div>
                                <div class="form-group col-12">
                                    <div wire:ignore>
                                        <label class="col-form-label">
                                            {{ __('Genera Horas Extras') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control" id="derecho_a_hora_extra" wire:model="derecho_a_hora_extra">
                                            <option value="No">No</option>
                                            <option value="Si">Si</option>
                                        </select>
                                    </div>
                                    @error('derecho_a_hora_extra') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12">
                                    <div wire:ignore>
                                        <label class="col-form-label">
                                            {{ __('Recontratable') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control" id="recontratable" wire:model="recontratable">
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                    @error('recontratable') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    {{--Horarios--}}
                    <div class="row rounded border mb-4">
                        <div class="bg-gray rounded-left">
                            <div class="m-3">
                                <i class="fa-solid fa-calendar-days"></i>
                            </div>
                        </div>
                        <div class="col m-2">
                            <div class="border-bottom">
                                <h5 class="py-1 text-center">Horario de Jornada Laboral</h5>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <div wire:ignore>
                                        <label class="col-form-label">
                                            {{ __('Horario predeterminados') }}
                                        </label>
                                        <select class="form-control" id="horario_predeterminado" wire:model="horario_predeterminado">
                                            <option value="">No</small> </option>
                                            <optgroup label="Horarios predeterminados">
                                            @foreach ($default_schedules as $default_schedule)
                                                <option value="{{$default_schedule->id}}">{{$default_schedule->nombre_del_horario}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('horario_predeterminado') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12">
                                    <label class="col-form-label">
                                        {{ __('Número de jornadas') }}
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
                                                                        <option>Lunes</option>
                                                                        <option>Martes</option>
                                                                        <option>Miércoles</option>
                                                                        <option>Jueves</option>
                                                                        <option>Viernes</option>
                                                                        <option>Sábado</option>
                                                                        <option>Domingo</option>
                                                                    </select>
                                                                    @error('day_entrada.jornada'.($i+1)) <span class="text-danger error">{{ $message }}</span> @enderror
                                                                    <input type="time" class="form-control border-0" id="entrada{{$i}}" required wire:model="hora_entrada.jornada{{$i+1}}">
                                                                    @error('hora_entrada.jornada'.($i+1)) <span class="text-danger error">{{ $message }}</span> @enderror
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
                                                                        @error('day_salida.jornada'.($i+1)) <span class="text-danger error">{{ $message }}</span> @enderror
                                                                        <input type="time" class="form-control border-0" id="salida{{$i}}" required wire:model="hora_salida.jornada{{$i+1}}">
                                                                        @error('hora_salida.jornada'.($i+1)) <span class="text-danger error">{{ $message }}</span> @enderror
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
                    {{--Documentos--}}
                    <div class="row rounded border mb-4">
                        <div class="bg-gray rounded-left">
                            <div class="m-3">
                                <div class="my-auto"><i class="fa-solid fa-folder"></i></div>
                            </div>
                        </div>
                        <div class="col m-2">
                            <div class="border-bottom">
                                <h5 class="py-1 text-center">Documentos</h5>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-sm-6 col-md-4 col-xl-4">
                                    <label class="col-form-label">
                                        {{ __('Identificación oficial / INE') }}
                                        {{-- <span class="text-danger">*</span> --}}
                                    </label>
                                    <input type="file" class="form-control-file" id="documento_de_identificación_oficial" wire:model.defer="documento_de_identificación_oficial">
                                    @error('documento_de_identificación_oficial') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12 col-sm-6 col-md-4 col-xl-4">
                                    <label class="col-form-label">
                                        {{ __('Comprobante de domicilio') }}
                                        {{-- <span class="text-danger">*</span> --}}
                                    </label>
                                    <input type="file" class="form-control-file" id="documento_del_comprobante_de_domicilio" wire:model.defer="documento_del_comprobante_de_domicilio">
                                    @error('documento_del_comprobante_de_domicilio') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12 col-sm-6 col-md-4 col-xl-4">
                                    <label class="col-form-label">
                                        {{ __('No atecendentes penales') }}
                                        {{-- <span class="text-danger">*</span> --}}
                                    </label>
                                    <input type="file" class="form-control-file" id="documento_de_no_antecedentes_penales" wire:model.defer="documento_de_no_antecedentes_penales">
                                    @error('documento_de_no_antecedentes_penales') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12 col-sm-6 col-md-4 col-xl-4">
                                    <label class="col-form-label">
                                        {{ __('Licencia de conducir') }}
                                    </label>
                                    <input type="file" class="form-control-file" id="documento_de_la_licencia_de_conducir" wire:model.defer="documento_de_la_licencia_de_conducir">
                                    @error('documento_de_la_licencia_de_conducir') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12 col-sm-6 col-md-4 col-xl-4">
                                    <label class="col-form-label">
                                        {{ __('Cedula profesional') }}
                                    </label>
                                    <input type="file" class="form-control-file" id="documento_de_la_cedula_profesional" wire:model.defer="documento_de_la_cedula_profesional">
                                    @error('documento_de_la_cedula_profesional') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12 col-sm-6 col-md-4 col-xl-4">
                                    <label class="col-form-label">
                                        {{ __('Carta de pasante') }}
                                    </label>
                                    <input type="file" class="form-control-file" id="documento_de_la_carta_de_pasante" wire:model.defer="documento_de_la_carta_de_pasante">
                                    @error('documento_de_la_carta_de_pasante') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12 col-sm-6 col-md-4 col-xl-4">
                                    <label class="col-form-label">
                                        {{ __('Curriculum Vitae (CV)') }}
                                        {{-- <span class="text-danger">*</span> --}}
                                    </label>
                                    <input type="file" class="form-control-file" id="documento_del_curriculum_vitae" wire:model.defer="documento_del_curriculum_vitae">
                                    @error('documento_del_curriculum_vitae') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12 col-sm-6 col-md-4 col-xl-4">
                                    <label class="col-form-label">
                                        {{ __('Contrato firmado') }}
                                        {{-- <span class="text-danger">*</span> --}}
                                    </label>
                                    <input type="file" class="form-control-file" id="documento_del_contrato" wire:model.defer="documento_del_contrato">
                                    @error('documento_del_contrato') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12 col-sm-6 col-md-4 col-xl-4">
                                    <label class="col-form-label">
                                        {{ __('Datos Bancarios') }}
                                        {{-- <span class="text-danger">*</span> --}}
                                    </label>
                                    <input type="file" class="form-control-file" id="documento_de_caratula_bancaria" wire:model.defer="documento_de_caratula_bancaria">
                                    @error('documento_de_caratula_bancaria') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12 col-sm-6 col-md-4 col-xl-4">
                                    <label class="col-form-label">
                                        {{ __('Cedula Fiscal') }}
                                        {{-- <span class="text-danger">*</span> --}}
                                    </label>
                                    <input type="file" class="form-control-file" id="documento_de_cedula_fiscal" wire:model.defer="documento_de_cedula_fiscal">
                                    @error('documento_de_cedula_fiscal') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12 col-sm-6 col-md-4 col-xl-4">
                                    <label class="col-form-label">
                                        {{ __('Curp') }}
                                        {{-- <span class="text-danger">*</span> --}}
                                    </label>
                                    <input type="file" class="form-control-file" id="documento_del_curp" wire:model.defer="documento_del_curp">
                                    @error('documento_del_curp') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12 col-sm-6 col-md-4 col-xl-4">
                                    <label class="col-form-label">
                                        {{ __('Requisicion Firmada') }}
                                        {{-- <span class="text-danger">*</span> --}}
                                    </label>
                                    <input type="file" class="form-control-file" id="documento_del_requisicion_firmada" wire:model.defer="documento_del_requisicion_firmada">
                                    @error('documento_del_requisicion_firmada') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12 col-sm-6 col-md-4 col-xl-4">
                                    <label class="col-form-label">
                                        {{ __('Acta de Nacimiento') }}
                                        {{-- <span class="text-danger">*</span> --}}
                                    </label>
                                    <input type="file" class="form-control-file" id="documento_del_acta_de_nacimiento" wire:model.defer="documento_del_acta_de_nacimiento">
                                    @error('documento_del_acta_de_nacimiento') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12 col-sm-6 col-md-4 col-xl-4">
                                    <label class="col-form-label">
                                        {{ __('Seguro Social') }}
                                        {{-- <span class="text-danger">*</span> --}}
                                    </label>
                                    <input type="file" class="form-control-file" id="documento_del_seguro_social" wire:model.defer="documento_del_seguro_social">
                                    @error('documento_del_seguro_social') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12 col-sm-6 col-md-4 col-xl-4">
                                    <label class="col-form-label">
                                        {{ __('Otros Documentos') }}
                                        {{-- <span class="text-danger">*</span> --}}
                                    </label>
                                    <input type="file" class="form-control-file" id="otros_documentos" wire:model.defer="otros_documentos">
                                    @error('otros_documentos') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--Rol--}}
                    @can('admin.roles.user')
                        <div class="row rounded border mb-4">
                            <div class="bg-gray rounded-left">
                                <div class="m-3">
                                    <div class="my-auto"><i class="fa-solid fa-unlock"></i></div>
                                </div>
                            </div>
                            <div class="col m-2">
                                <div class="border-bottom">
                                    <h5 class="py-1 text-center">Rol</h5>
                                </div>
                                <div>
                                    <div class="form-group">
                                        <label class="col-form-label">
                                            {{ __('Rol') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control" aria-label="Default select example" wire:model="role">
                                            <option value="">Selecciona una opción</option>
                                            @foreach ($roles as $role)
                                                <option value="{{$role->id}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('role') <span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div>
                                        <label class="col-form-label">
                                            {{ __('Estatus') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control" id="estatus" wire:model="estatus">
                                            <option value="Activo">Activo</option>
                                            <option value="Inactivo">Inactivo (No se le generará inasistencias)</option>
                                            <option value="Baja definitiva">Baja definitiva (Ya no elabora)</option>
                                        </select>
                                    </div>
                                    @error('estatus') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                    @endcan
                    {{--Contaseña--}}
                    <div class="row rounded border">
                        <div class="bg-gray rounded-left">
                            <div class="m-3">
                                <div class="my-auto"><i class="fa-solid fa-key"></i></div>
                            </div>
                        </div>
                        <div class="col m-2">
                            <div class="border-bottom">
                                <h5 class="py-1 text-center">Contraseña</h5>
                            </div>
                            <div>
                                <div class="row">
                                    <div wire:model="registrarPor" class="m-3 col-12">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="curp" checked>
                                            <label class="form-check-label" for="inlineRadio1">Registrar por CURP</label>
                                        </div>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="password">
                                            <label class="form-check-label" for="inlineRadio2">Registrar por contraseña</label>
                                        </div>
                                    </div>
                                    @if ($registrarPor == 'password')
                                        <div class="form-group col-12 col-md-6 col-sm-6">
                                            <label class="col-form-label">
                                                {{ __('Contraseña') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input id="password" type="password" class="form-control" wire:model="password" required autocomplete="new-password" placeholder="Ingrese la contraseña del empleado">
                                            <span class="password-icon" onclick="togglePasswordVisibility()" style="position: absolute; top: 75%; right: 10px; transform: translateY(-50%); cursor: pointer;" >
                                                <i class="fas fa-eye"></i>
                                            </span> 
                                            @error('password') <span class="text-danger error">{{ $message }}</span>@enderror

                                        </div>
                                        <div class="form-group col-12 col-md-6 col-sm-6">
                                            <label class="col-form-label">
                                                {{ __('Confirmar contraseña') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input id="passwords" type="password" class="form-control" wire:model="password_confirmation" required autocomplete="new-password" placeholder="Nuevamente ingrese la contraseña del empleado">
                                            <span class="password-icon" onclick="togglePasswordVisibilitys()" style="position: absolute; top: 75%; right: 10px; transform: translateY(-50%); cursor: pointer;" >
                                                <i class="fas fa-eye"></i>
                                            </span> 
                                            @error('password') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="text-center">
                <button type="button" wire:loading.attr="disabled" wire:click.prevent="save()" wire:target="save, foto, documento_de_identificación_oficial, documento_del_comprobante_de_domicilio, documento_de_no_antecedentes_penales, documento_de_la_licencia_de_conducir, documento_de_la_cedula_profesional, documento_de_la_carta_de_pasante, documento_del_curriculum_vitae, documento_del_contrato, documento_de_caratula_bancaria, documento_de_cedula_fiscal, documento_del_curp, documento_del_requisicion_firmada, documento_del_acta_de_nacimiento, documento_del_seguro_social, otros_documentos" class="btn btn-success">Guardar</button>
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
    <script>
        $(document).ready(function () {
            $('#companies').select2({
                theme: 'bootstrap4'
            });

            $('#companies').on('change', function (e) {
                var data = $('#companies').select2("val");
            @this.set('company', data);
            });

            $('#cost_centers').select2({
                theme: 'bootstrap4'
            });

            $('#cost_centers').on('change', function (e) {
                var data = $('#cost_centers').select2("val");
            @this.set('cost_center', data);
            });

            $('#users').select2({
                theme: 'bootstrap4'
            });

            $('#users').on('change', function (e) {
                var data = $('#users').select2("val");
            @this.set('encargado', data);
            });
            /////

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

<script>
        // JavaScript definido directamente en el archivo Blade
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var passwordIcon = document.querySelector(".password-icon");

                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    passwordIcon.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    passwordInput.type = "password";
                    passwordIcon.innerHTML = '<i class="fas fa-eye"></i>';
                }
                
        }
        function togglePasswordVisibilitys() {
            var passwordInput = document.getElementById("passwords");
            var passwordIcon = document.querySelector(".password-icon");

                if (passwordInput.type === "passwords") {
                    passwordInput.type = "texts";
                    passwordIcon.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    passwordInput.type = "passwords";
                    passwordIcon.innerHTML = '<i class="fas fa-eye"></i>';
                }
                
        }
        // Agregar otras funciones o lógica aquí
</script>
