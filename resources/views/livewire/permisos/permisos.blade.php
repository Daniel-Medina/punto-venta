<div class="row sales layout-top-spacing">

    <div class="col-sm-12">

        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>

                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal" data-target="#theModal">
                            Agregar
                        </a>
                    </li>
                </ul>
            </div>

            @include('common.searchbox')

            <div class="widget-content">

                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3b3f5c;">
                            <tr>
                                <th class="table-th text-white">ID</th>
                                <th class="table-th text-white text-center">Descripción</th>
                                <th class="table-th text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permisos as $permiso)
                            
                            @switch($permiso->name)
                                @case('Permisos - Ver')
                                    @break
                                @case('Permisos - Editar')
                                    @break
                                @case('Permisos - Agregar')
                                @break
                                @case('Permisos - Eliminar')
                                    @break
                                @default                                    
                                    <tr>
                                        <td ><h6>{{$loop->iteration}}</h6></td>
                                        <td class="text-center">
                                            <h6>{{$permiso->name}}</h6>
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" wire:click="Edit({{$permiso->id}})" class="btn btn-dark mtmobile" title="Editar registro">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0)" onclick="Confirm('{{$permiso->id}}')" class="btn btn-dark" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                            @endswitch
                            @endforeach
                        </tbody>
                    </table>

                    {{$permisos->links()}}
                </div>

            </div>

        </div>

    </div>

    @include('livewire.permisos.form')

</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        window.livewire.on('permission-added', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('permission-updated', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('permission-deleted', Msg => {
            noty(Msg)
        })
        window.livewire.on('permission-exists', Msg => {
            noty(Msg)
        })
        window.livewire.on('permission-error', Msg => {
            noty(Msg)
        })
        window.livewire.on('hide-modal', Msg => {
            $('#theModal').modal('hide')
        })
        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show')
        })
        window.livewire.on('hidden.bs.modal', Msg => {
            $('.er').css('display', 'none')
        })
    });


    function Confirm(id, products)
    {
        console.log(products)
        if(products > 0) {
            Swal('No se puede Eliminar una Categoria con productos')
            return;
        }

        Swal({
        title: 'CONFIRMAR',
        text: '¿Desea Eliminar el registro?',
        type: 'warning',
        showCancelButton: true,
        cancelButtonText: 'CERRAR',
        cancelButtonColor: '#fff',
        confirmButtonColor: '#3b3f5c',
        confirmButtonText: 'ACEPTAR',
        }).then(function(result) {
            if(result.value) {
                window.livewire.emit('deleteRow', id);
                Swal.close();
            }
        });
    }
</script>