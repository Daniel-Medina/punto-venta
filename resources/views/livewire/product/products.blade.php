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
                                <th class="table-th text-white">DESCRIPCION</th>
                                <th class="table-th text-white text-center">C. BARRAS</th>
                                <th class="table-th text-white text-center">CATEGORIAS</th>
                                <th class="table-th text-white text-center">PRECIO</th>
                                <th class="table-th text-white text-center">RESTANTES</th>
                                <th class="table-th text-white text-center">INV. MIN.</th>
                                <th class="table-th text-white text-center">IMAGEN</th>
                                <th class="table-th text-white text-center">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                
                                <tr>
                                    <td><h6>{{$product->name}}</h6></td>
                                    <td><h6 class="text-center">{{$product->barcode}}</h6></td>
                                    <td><h6 class="text-center">{{$product->category}}</h6></td>
                                    <td><h6 class="text-center">{{$product->price}}</h6></td>
                                    <td><h6 class="text-center">{{$product->stock}}</h6></td>
                                    <td><h6 class="text-center">{{$product->alerts}}</h6></td>
                                    <td class="text-center">
                                        <span>
                                            <img src="{{Storage::url($product->imagen)}}" alt="imagen de ejemplo" height="70" width="80" class="rounded">
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click.prevent="Edit({{$product->id}})" class="btn btn-dark mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" onclick="Confirm('{{$product->id}}')"
                                            class="btn btn-dark" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{$products->links()}}
                    <strong>Total: {{$products->count()}} resultados</strong>
                </div>

            </div>

        </div>

    </div>

    @include('livewire.product.form')

</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {

        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });

        window.livewire.on('product-added', msg => {
            $('#theModal').modal('hide');
        });

        window.livewire.on('product-updated', msg => {
            $('#theModal').modal('hide');
        });

        window.livewire.on('product-deleted', msg => {
            Swal('Eliminado Correctamente')
        });

        window.livewire.on('modal-show', msg => {
            $('#theModal').modal('hide');
        });

        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide');
        });

        $('#theModal').on('hidden.ns.modal', function() {
            $('.er').css('display', 'none')
        });
    });

    function Confirm(id)
    {
       /*  if(products > 0) {
            Swal('No se puede Eliminar una Categoria con productos')
            return;
        } */

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