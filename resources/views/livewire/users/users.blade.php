<div class="row sales layout-top-spacing">

    <div class="col-sm-12">

        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>

                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal" data-target="#theModal" wire:click.prevent="resetUI()">
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
                                <th class="table-th text-white">Usuario</th>
                                <th class="table-th text-white text-center">Teléfono</th>
                                <th class="table-th text-white text-center">Email</th>
                                <th class="table-th text-white text-center">Perfil</th>
                                <th class="table-th text-white text-center">Estatus</th>
                                <th class="table-th text-white text-center">Imagen</th>
                                <th class="table-th text-white text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $r)
                                <tr>
                                    <td><h6>{{$r->name}}</h6></td>
                                    <td class="text-center"><h6>{{$r->phone}}</h6></td>
                                    <td class="text-center"><h6>{{$r->email}}</h6></td>
                                    <td class="text-center text-uppercase"><h6>{{$r->profile}}</h6></td>
                                    <td class="text-center">
                                        <span class="badge {{$r->status == 'ACTIVE' ? 'badge-success' : 'badge-danger'}} text-uppercase">
                                            {{$r->status == 'ACTIVE' ? 'ACTIVO' : 'INACTIVO'}}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($r->image != null)
                                            <img src="{{asset('storage/' . $r->image)}}" alt="imagen de Usuario" width="60" height="60" style="border-radius: 100%; object-fit: cover;">
                                        @endif
                                        <!-- ========== Start usar accesor ========== -->
                                            
                                        <!-- ========== End usar accesor ========== -->
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="btn btn-dark mtmobile" wire:click="edit({{$r->id}})" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" class="btn btn-dark" onclick="Confirm('{{$r->id}}')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{$data->links()}}
                </div>

            </div>

        </div>

    </div>

    @include('livewire.users.form')

</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        window.livewire.on('user-added', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('user-updated', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('user-deleted', Msg => {
            noty(Msg)
        })
        window.livewire.on('hide-modal', Msg => {
            $('#theModal').modal('hide')
        })
        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show')
        })
        window.livewire.on('user-withsales', Msg => {
            noty(Msg)
        })
    });


    function Confirm(id, products)
    {
        Swal({
        title: 'CONFIRMAR',
        text: '¿Desea Eliminar el usuario?',
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