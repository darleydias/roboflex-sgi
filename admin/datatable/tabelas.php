

<!-- INCLUDE PARA AS PAGINAS COM TABELAS -->
<!-- <.?php include_once ('datatable/tabelas.php'); ?> -->

<script>
$(document).ready(function(){
	$('#tb_apontamento').DataTable({
		language: {
			url: 'http://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
		}
	})

	$('#tb_autorizacao').DataTable({
		order: [ 5, 'desc' ],
		language: {
			url: 'http://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
		}
	})



	$('#tb_parcial').DataTable({
  		 language: {
  		 url: 'http://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
		}
		})

	$('#tb_emprestimo').DataTable({
  		 language: {
  		 url: 'http://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
		}
		})

	$('#tb_estoque').DataTable({
  		 language: {
  		 url: 'http://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
		}
		})

	$('#tb_saida').DataTable({
  		 language: {
  		 url: 'http://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
		}
		})





/* Categoria de materiais e serviços */


var table = $('#tb_tipo').DataTable({
		 order: [ 0, 'desc' ],
  		 language: {
  		 url: 'http://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
		}
		})




	$('#tb_usuarios').DataTable({
  		 language: {
  		 url: 'http://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
		}
		})



		/* Lista de materiais e serviços */

    var table = $('#tb_item').DataTable({
		pageLength: 20,
		columnDefs: [
            {"width": 50, "type": "num", "targets": 0 }, /* # */
            {"width": 250, "targets": 1 }, /* nome */
            {"width": 100, "targets": 2 }, /* cod */
            {"width": 150, "targets": 3 }, /* cat */
            {"width": 120, "targets": 4 }, /* criacao */
            {"width": 100, "targets": 5 }, /* status */
            {"width": 100, "targets": 6 }, /* funcao */
        ],
		 order: [ 1, 'desc' ],
  		 language: {
  		 url: 'http://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
		}
		
		});
})

</script>