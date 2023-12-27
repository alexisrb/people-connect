<div>
    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#scheduleEdit{{$schedule->id}}Modal"><i class="fas fa-edit"></i></button>

    <div class="modal fade" id="scheduleEdit{{$schedule->id}}Modal" tabindex="-1" role="dialog" aria-labelledby="scheduleEdit{{$schedule->id}}ModalLarabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleEdit{{$schedule->id}}ModalLarabel">Editar día del horario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <div>
                                <label class="col-form-label">
                                    {{ __('Día') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" id="tipo" wire:model="día">
                                    <option value="">Selecciona una opción</option>
                                    <option>Lunes</option>
                                    <option>Martes</option>
                                    <option>Jueves</option>
                                    <option>Viernes</option>
                                    <option>Sabado</option>
                                    <option>Domingo</option>
                                </select>
                            </div>
                            @error('tipo') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">
                                {{ __('Hora de entrada') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="time" id="hora_de_entrada" class="form-control" wire:model="hora_de_entrada">
                            @error('hora_de_entrada') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">
                                {{ __('Hora de salida') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="time" id="hora_de_salida" class="form-control" wire:model="hora_de_salida">
                            @error('hora_de_salida') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>