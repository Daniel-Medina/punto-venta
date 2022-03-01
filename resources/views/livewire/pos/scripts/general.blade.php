<script type="text/javascript">

    function Confirm(id, eventName, text)
    {
        Swal({
        title: 'CONFIRMAR',
        text: text,
        type: 'warning',
        showCancelButton: true,
        cancelButtonText: 'CERRAR',
        cancelButtonColor: '#fff',
        confirmButtonColor: '#3b3f5c',
        confirmButtonText: 'ACEPTAR',
        }).then(function(result) {
            console.log(eventName)
            if(result.value) {
                window.livewire.emit(eventName, id);
                Swal.close();
            }
        });
    }

</script>

<script src="">

$(document).ready(function() {
         $("tblscroll").niceScroll({
        cursorcolor: "#515365",
        cursorwidth: "30px",
        background:"rgba(20,20,20,0.3)",
        cursorborder: "0px",
        cursorborderradius: 3,
    })
    });
   
</script>