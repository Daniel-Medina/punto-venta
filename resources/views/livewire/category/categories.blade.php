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
                                <th class="table-th text-white">Descripcion</th>
                                <th class="table-th text-white">Image</th>
                                <th class="table-th text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($categories as $category)
                                <tr>
                                    <td><h6>{{$category->name}}</h6></td>
                                    <td class="text-center">
                                        <span>
                                            <img src="{{Storage::url($category->imagen)}}" alt="" height="70" width="80" class="rounded">
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{$category->id}})" class="btn btn-dark mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <a href="javascript:void(0)" 
                                        onclick="Confirm('{{$category->id}}', '{{$category->products->count()}}')" 
                                        class="btn btn-dark" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    
                    <div class="col-sm-12">
                        {{$categories->links()}}
                    </div>
                </div>

            </div>

        </div>
 
    </div>

    @include('livewire.category.form')

</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });

        window.livewire.on('category-added', msg => {
            $('#theModal').modal('hide');
        });

        window.livewire.on('category-updated', msg => {
            $('#theModal').modal('hide');
        });

        window.livewire.on('category-deleted', msg => {
            Swal('Eliminado Correctamente')
        });
        
        $('#theModal').on('hidden.ns.modal', function() {
            $('.er').css('display', 'none')
        });
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
 