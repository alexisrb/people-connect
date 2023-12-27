<div class="py-4">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb">
            @can('admin.extra_hours.index')
                <li class="breadcrumb-item"><a href="{{route('admin.extra_hours.index')}}">Todas las horas extras</a></li>
            @endcan
            <li class="breadcrumb-item active">Registrar horas extras</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header bg-primary">
            <h5 class="text-center my-2">Horas extras</h5>
        </div>
        <div class="card-body">
            <form>
                <div class="g-3">
                    {{--Pincel--}}
                    <div class="row rounded border">
                        <div class="bg-gray rounded-left">
                            <div class="m-3">
                                <div class="my-auto"><i class="fas fa-pencil-alt"></i></div>
                            </div>
                        </div>
                        <div class="col m-2">
                            <div class="border-bottom">
                                <h5 class="py-1 text-center">Hora extra</h5>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label class="col-form-label">
                                        {{ __('Horas') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" id="horas" class="form-control" wire:model="horas">
                                    @error('horas') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12">
                                    <label class="col-form-label">
                                        {{ __('Fecha') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" id="fecha" class="form-control" wire:model="fecha">
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
                                                <option value="{{ $user->id}}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('user') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-12" wire:ignore>
                                    <label for="observación" class="col-form-label">{{ __('Observación') }}</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" id="observación" name="observación" class="form-control" wire:model="observación" placeholder="Ingrese la observación">
                                </div>
                                @error('observación') <span class="text-danger error">{{ $message }}</span>@enderror
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
        $('#observación').summernote({
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
            ],
            callbacks: {
                onChange: function(contents, $editable) {
                    @this.set('observación', contents);
                }
            }
        });
    </script>


    <script>
        $(document).ready(function () {

            $('#users').select2({
                theme: 'bootstrap4'
            });

            $('#users').on('change', function (e) {
                var data = $('#users').select2("val");
            @this.set('user', data);
            });
        });
    </script>
@endpush
