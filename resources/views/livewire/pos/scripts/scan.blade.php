<script>


    try{

    onScan.attachTo(document, {
        suffixKeyCodes: [13],
        reactToPaste: true,

        onScan: function(barcode) {
            console.log(barcode)
            window.livewire.emit('scan-code', barcode)
        },

        onScanError: function (e) {
            console.log(e)
        }

    })

    console.log('Escaner Listo')

    } catch(e) {
        console.log('Error de lectura: ' + e)
    }


</script>