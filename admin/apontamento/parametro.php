<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>

<style>

body{
    zoom: 90%;
}

</style>
<div class="card card-outline card-gray" style="width: 100%;">
<div class="card-body">
<div class="container-fluid">

<!-- head inicio -->
<div class="row justify-content-center">
<div class="col" style="width:100%;">
<a style="width:100%;" onclick="window.location='<?php echo base_url ?>admin/?page=apontamento'" class="btn btn-outline-secondary"><strong> VOLTAR </strong>  <!-- <span class="fas fa-circle-xmark"></span> --></a>
</div>
</div>
<br>
<!-- head fim -->


<?php if($_settings->userdata('usuario_setor') == 'ADM') { ?>
<div id="pdf-setor1" class="text-center"></div>

<?php } elseif($_settings->userdata('usuario_setor') == 'setor2') { ?>
<div id="pdf-setor2" class="text-center"></div>

<?php } elseif($_settings->userdata('usuario_setor') == 'setor3') { ?>
<div id="pdf-setor3" class="text-center"></div>

<?php } elseif($_settings->userdata('usuario_setor') == 'setor4') { ?>
<div id="pdf-setor4" class="text-center"></div>

<?php } elseif($_settings->userdata('usuario_setor') == 'setor5') { ?>
<div id="pdf-setor5" class="text-center"></div>

<?php } elseif($_settings->userdata('usuario_setor') == 'setor6') { ?>
<div id="pdf-setor6" class="text-center"></div>

<?php } elseif($_settings->userdata('usuario_setor') == 'setor7') { ?>
<div id="pdf-setor7" class="text-center"></div>

<?php } ?>

</div> <!--  container -->
</div> <!-- card body -->
</div> <!-- card -->


<script>

// pdf-setor1
var url = '<?php echo base_url; ?>' + 'admin/anexo/upload_parametro/1111ele.pdf?=' + Date.now();
pdfjsLib.getDocument(url).promise.then(function(pdf) {

// quando o PDF tem varias páginas

    /* for(var i=1; i<=3; i++){
    pdf.getPage(i).then(function(page) { */

    pdf.getPage(1).then(function(page) {
    var canvas = document.createElement('canvas');
    var context = canvas.getContext('2d');
    var scale = window.devicePixelRatio || 1;
    var viewport = page.getViewport({scale: scale});

    canvas.height = viewport.height;
    canvas.width = viewport.width;

    canvas.style.maxWidth = "100%";
    canvas.style.height = "auto";

    page.render({
      canvasContext: context,
      viewport: viewport
    }).promise.then(function() {
      document.getElementById('pdf-setor1').appendChild(canvas);
    });
  });

// fechar chave pdf
/* } */

});

</script>
