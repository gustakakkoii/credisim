<script>
    $("#CPF").inputmask({
        mask: "999.999.999-99"
    });
    $("#CEP").inputmask({
        mask: "99999-999"
    });
    $("#Celular").inputmask({
        mask: "(99) 99999-9999"
    });
    $("#Telefone").inputmask({
        mask: "(99) 99999-9999"
    });
    $("#Nascimento").inputmask({
        mask: "99/99/9999"
    });
    $("#beneficio").inputmask({
        mask: "999.999.999-9"
    });
    
    function enviar(id) {
        form = document.querySelector(id);
        form.submit();
    }
</script>