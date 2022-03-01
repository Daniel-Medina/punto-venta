<div class="row mt-3">
    <div class="col-sm-12">
        <div class="connect-sorting">

            <h5 class="text-center mb-2">DENOMINACIONES</h5>

            <div class="container">
                <div class="row">
                    @foreach ($denominations as $denomination)
                        <div class="col-sm-6 col-xxl-4 mt-2">
                            <button wire:click.prevent="ACash({{$denomination->value}})" class="btn btn-dark btn-block den">
                                {{$denomination->value > 0 ? '$'. number_format($denomination->value, 2, '.', '') : 'EXACTO' }}
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="connect-sorting-content mt-4">
                <div class="card simple-title-task ui-sortable-handle">
                    <div class="card-body">
                        <div class="input-group input-group-md mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text input-gp hideonsm" style="background: #3b3f5c; color: white;">
                                    EFECTIVO F8
                                </span>
                            </div>
                            <input type="number" id="cash" wire:model.lazy="efectivo" wire:keydown.enter="saveSale"  class="form-control text-center" value="{{$efectivo}}">

                            <div class="ipnut-group-append">
                                <span class="input-group-text" wire:click="$set('efectivo', 0)" style="background: #3b3f5c; color: white; cursor: pointer;">
                                    <i class="fas fa-backspace fa-2x"></i>
                                </span>
                            </div>
                        </div>


                        <h4 class="text-muted">Cambio: {{number_format($change, 2)}}</h4>

                        <div class="row justify-content-between mt-5">
                            <div class="col-sm-12 col-md-12 col-lg-6">

                                @if ($total > 0)
                                    <button class="btn btn-dark btn-block mtmobile"
                                    onclick="Confirm('', 'clearCart', '¿CANCELAR LA VENTA?')">
                                        CANCELAR F4
                                    </button>
                                @endif

                            </div>


                            <div class="col-sm-12 col-md-12 col-lg-6">
                                @if ($efectivo >= $total && $total > 0)
                                    <button class="btn btn-dark btn-md btn-block" onclick="Confirmar('Desea guardar la venta')">
                                        GUARDAR F9
                                    </button>
                                    {{-- <button class="btn btn-dark btn-md btn-block" wire:click.prevent="saveSale">
                                        GUARDAR F9
                                    </button> --}}
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>

function Confirmar(text)
    {
        Swal({
        title: 'CONFIRMAR',
        text: text + '?',
        type: 'warning',
        showCancelButton: true,
        cancelButtonText: 'CERRAR',
        cancelButtonColor: '#fff',
        confirmButtonColor: '#3b3f5c',
        confirmButtonText: 'ACEPTAR',
        }).then(function(result) {
            if(result.value) {
                window.livewire.emit('saveSale');
                Swal.close();
            }
        });
    }

</script>