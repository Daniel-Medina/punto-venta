<script>


    var listener = new window.keypress.Listener();

    listener.simple_combo("f9", function() {
        //livewire.emit('saveSale');
        Confirmar('Desea guardar la venta')
    })


    listener.simple_combo("f8", function() {
        document.getElementById('cash').value=''
        document.getElementById('cash').focus()
    })


    listener.simple_combo("f4", function() {
        var total = parseFloat(document.getElementById('hiddenTotal').value)

        if(total > 0) {
            Confirm(0, 'clearCart', '¿ELIMINAR LA VENTA?')
        } else {
            noty('AGREGA PRODUCTOS A LA VENTA')
        }
    })

</script>