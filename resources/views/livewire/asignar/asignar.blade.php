<div class="row sales layout-top-spacing">

    <div class="col-sm-12">

        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}}</b>
                </h4>

            </div>

            <div class="widget-content">
                <div class="form-inline">
                    <div class="form-group mr-5">
                        <select class="form-control" wire:model="role">
                            <option value="Elegir" selected>Seleccione Rol</option>
                            @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="button" wire:click.prevent="syncAll()" class="btn btn-dark mbmobile inblock mr-5">Sincronizar todos</button>
                    <button type="button" onclick="Revocar()" class="btn btn-dark mbmobile mr-5">Revocar todos</button>
                </div>


                <div class="row mt-3">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3b3f5c;">
                            <tr>
                                <th class="table-th text-white text-center">ID</th>
                                <th class="table-th text-white text-center">Permisos</th>
                                <th class="table-th text-white text-center">Roles con permisos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permisos as $permiso)
                                <tr>
                                    <td>
                                        {{-- <h6 class="text-center">{{$permiso->id}}</h6> --}}
                                        <h6 class="text-center">{{$loop->iteration}}</h6>
                                    </td>
                                    <td class="text-left">
                                        
                                        <div class="n-chk">
                                            <label class="new-control new-checkbox checkbox-primary">
                                                <input type="checkbox"
                                                    wire:change="syncPermiso($('#p'  + {{$permiso->id}}).is(':checked'), '{{$permiso->name}}' )"
                                                    id="p{{$permiso->id}}"
                                                    value="{{$permiso->id}}"
                                                    class="new-control-input"
                                                    {{$permiso->checked == 1 ? 'checked' : ''}}>
                                                <span class="new-control-indicator"></span><h6>{{$permiso->name}}</h6>
                                            </label>
                                        </div>

                                    </td>

                                    <td class="text-center">
                                        <h6>{{ App\Models\User::permission($permiso->name)->count()}}</h6>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{$permisos->links()}}
                </div>
                    </div>
                </div>

                

            </div>

        </div>

    </div>

</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        window.livewire.on('sync-error', Msg => {
            noty(Msg)
        })
        window.livewire.on('permi', Msg => {
            noty(Msg)
        })
        window.livewire.on('syncall', Msg => {
            noty(Msg)
        })
        window.livewire.on('removeall', Msg => {
            noty(Msg)
        })
    });

    function Revocar()
    {

        Swal({
        title: 'CONFIRMAR',
        text: '¿Desea Eliminar todos los permisos?',
        type: 'warning',
        showCancelButton: true,
        cancelButtonText: 'CERRAR',
        cancelButtonColor: '#fff',
        confirmButtonColor: '#3b3f5c',
        confirmButtonText: 'ACEPTAR',
        }).then(function(result) {
            if(result.value) {
                window.livewire.emit('revokeall');
                Swal.close();
            }
        });
    }
</script>
