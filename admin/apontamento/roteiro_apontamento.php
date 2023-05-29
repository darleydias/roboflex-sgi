<?php '' ?>
<?php
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT p.*
    FROM apontamento_roteiro p
    where p.id = '{$_GET['id']}'");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_array() as $k => $v) {
            $$k = $v;
        }
    }
}
?>

<form action="" id="roteiro-form" enctype="multipart/form-data">
        
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">

            <div class="container-fluid">
                <!-- INICIO EDIÇÃO -->
                <div class="row justify-content-around">
                    <div class="col-12 col-sm-6 col-md-3 text-center">
                    <label for="op_codigo" class="control-label">Código da OP</label>
                    <input type="number" min="1000" max="9999" autocomplete="off" name="op_codigo" id="op_codigo" class="form-control rounded-0 text-center" value="<?php echo isset($op_codigo) ? $op_codigo : ''; ?>" required>
                    </div>
                </div> <!-- fim linha -->
            </div>

</form> <!-- form -->
<script>
    $(function() {        
        $('#roteiro-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this)
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_roteiro",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err)
                    alert_toast("Ocorreu um erro", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (resp.status == 'success') {
                        /* location.replace(_base_url_ + "admin/?page=apontamento"); */
                        location.replace(_base_url_ + "admin/?page=apontamento/gerencia_apontamento");
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        var el = $('<div>')
                        el.addClass("alert alert-danger err-msg").text(resp.msg)
                        _this.prepend(el)
                        el.show('slow')
                        end_loader()
                    } else {
                        alert_toast("Ocorreu um erro", 'error');
                        end_loader();
                        console.log(resp)
                    }
                    $('html,body').animate({
                        scrollTop: 0
                    }, 'fast')
                }
            })
        })   
    })  
</script>

