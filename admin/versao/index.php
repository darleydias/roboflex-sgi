
<style>
body{
zoom: 90%;
}
</style>

<div class="card card-outline card-success">
    <div class="card-header">
        <h4 class="padding center text-dark text-center">Histórico das Versões </h4>
    </div>
    <div class="card-body">
            <div class="container-fluid">


        

<div class="row justify-content-around">

<div>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i><strong> Melhoria</strong>
</div>
<div>
<i class="fa-solid fa-trash" style="color:slategray;"></i><strong> Remoção</strong>
</div>
<div>
<i class="fa-solid fa-diamond" style="color:mediumslateblue "></i><strong> Adição</strong>
</div>
<div>
<i class="fa-solid fa-circle-xmark" style="color:crimson;"></i><strong> Correção</strong>
</div>
</div>
<br>

<div class="row justify-content-around">
  <div class="d-flex align-middle">
    <a class="btn btn-outline-secondary" data-toggle="collapse" href="#collapseVersao101"
      role="button" aria-expanded="false" aria-controls="collapseVersao101"
      data-parent="#accordion"> Versão 1.01 </a>
  </div>

  <div class="d-flex align-middle">
    <a class="btn btn-outline-secondary" data-toggle="collapse" href="#collapseVersao102"
      role="button" aria-expanded="false" aria-controls="collapseVersao102"
      data-parent="#accordion"> Versão 1.02 </a>
  </div>

  <div class="d-flex align-middle">
    <a class="btn btn-outline-secondary" data-toggle="collapse" href="#collapseVersao103"
      role="button" aria-expanded="false" aria-controls="collapseVersao103"
      data-parent="#accordion"> Versão 1.03 </a>
  </div>

  <div class="d-flex align-middle">
    <a class="btn btn-outline-secondary" data-toggle="collapse" href="#collapseVersao104"
      role="button" aria-expanded="false" aria-controls="collapseVersao104"
      data-parent="#accordion"> Versão 1.04 </a>
  </div>

  <div class="d-flex align-middle">
    <a class="btn btn-outline-secondary" data-toggle="collapse" href="#collapseVersao105"
      role="button" aria-expanded="false" aria-controls="collapseVersao105"
      data-parent="#accordion"> Versão 1.05 </a>
  </div>

  <div class="d-flex align-middle">
    <a class="btn btn-outline-secondary" data-toggle="collapse" href="#collapseVersao106"
      role="button" aria-expanded="false" aria-controls="collapseVersao106"
      data-parent="#accordion"> Versão 1.06 </a>
  </div>

<?php if($_settings->userdata('username') == 'Admin'): ?>

  <div class="d-flex align-middle">
    <a class="btn btn-outline-secondary" data-toggle="collapse" href="#collapseVersao107"
      role="button" aria-expanded="false" aria-controls="collapseVersao107"
      data-parent="#accordion"> Versão 1.07 </a>
  </div>

<?php endif; ?>

</div>

<br>
<div id="accordion">
<div class="collapse" id="collapseVersao101" data-parent="#accordion">
<i class="fa-solid fa-angle-double-up" style="color:green;"></i>
Formatação das páginas visualização e financeiro. <br>  
<i class="fa-solid fa-trash" style="color:slategray;"></i>
Remoção botão em andamento, da página omie. <br>
<i class="fa-solid fa-diamond" style="color:mediumslateblue;"></i>
Buscar material através código, além do nome. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i>
Barrar CNPJ iguais na inclusão de fornecedores. <br>
<i class="fa-solid fa-diamond" style="color:mediumslateblue;"></i>
Criação de novos grupos de usuários. <br>
<i class="fa-solid fa-diamond" style="color:mediumslateblue;"></i>
Adicionado botão para criação de materiais e serviços na pagina de solicitações;
apenas para determinado grupo de usuários. <!-- ID 6 (Autorização Administrativo). --> <br>
<i class="fa-solid fa-circle-xmark" style="color:crimson;"></i>
Nomenclaturas na página requisição de serviço. <br>
<i class="fa-solid fa-trash" style="color:slategray;"></i>
Remoção completa da categoria de compra da página de requisição. <br>
<i class="fa-solid fa-diamond" style="color:mediumslateblue;"></i>
Atualização nos grupos de usuários. <!-- ID 18(Compras matérias-primas). --> <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i>
Atualização do campo observação para comportar textos com mais caracteres. <br>
<i class="fa-solid fa-circle-xmark" style="color:crimson;"></i>
Correção no campo de observações da requisição. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i>
Limite máximo de caracteres aumentado do campo de observação da tabela. <br>
<i class="fa-solid fa-diamond" style="color:mediumslateblue;"></i>
Necessário preencher ao menos 1 cotação para finalizar a etapa. <br>
<i class="fa-solid fa-circle-xmark" style="color:crimson;"></i>
Remoção do campo de custo dos materiais e serviços. <br>
<i class="fa-solid fa-diamond" style="color:mediumslateblue;"></i>
Disponibilizado nova função, upload de arquivos. <br>
<i class="fa-solid fa-diamond" style="color:mediumslateblue;"></i>
Visualização dos uploads nas páginas seguintes a requisição. <br>
</div>


<div class="collapse" id="collapseVersao102" data-parent="#accordion">
<i class="fa-solid fa-circle-xmark" style="color:crimson;"></i>
Correção nos campos de observação e observação da Aprovação. <br>
<i class="fa-solid fa-diamond" style="color:mediumslateblue "></i>
Atualização dos grupos de usuários. <!-- ID 04 E 10. --> <br>
<i class="fa-solid fa-circle-xmark" style="color:crimson;"></i>
Algumas nomenclaturas corrigidas na página Requisição de Materiais. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i> 
Alterações em todos os campos de observação. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i> 
Na página de Visualização, removido os campos código projeto e
nome projeto, caso a opção do projeto seja "Não". <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i> 
Alteração do nome "Valor" para "Valor Total", para evitar ambiguidade. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i> 
Adicionado símbolo monetário em todas as páginas que envolvem valores. <br>
<i class="fa-solid fa-diamond" style="color:mediumslateblue "></i> 
Adicionado nova medição no tipo do item. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i>
Todos os anexos agora aceitam tanto PDF quanto Imagem. <br>
<i class="fa-solid fa-trash" style="color:slategray;"></i>
Removida a possibilidade de finalizar uma requisição ao pressionar a tecla "Enter". <br>
<i class="fa-solid fa-diamond" style="color:mediumslateblue "></i> 
Adicionado acompanhamento de todas as requisições realizadas. <br>
<i class="fa-solid fa-diamond" style="color:mediumslateblue "></i> 
Adicionado registro sobre quem está realizando a requisição. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i> 
Fixação de determinadas colunas nas páginas de cotação, aprovação e pedido de compra. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i> 
Ajuste no tamanho em todas as tabelas. <br>
</div>


<div class="collapse" id="collapseVersao103" data-parent="#accordion">
<i class="fa-solid fa-diamond" style="color:mediumslateblue "></i>
Possibilidade de editar requisição, somente antes da autorização. <br>
<i class="fa-solid fa-diamond" style="color:mediumslateblue "></i>
Criação de PDF a partir da requisição realizada. <br>
<i class="fa-solid fa-circle-xmark" style="color:crimson;"></i> 
Corrigido botões e ícones na sessão de anexos. <br>
<i class="fa-solid fa-circle-xmark" style="color:crimson;"></i> 
Corrigido bug onde as compras de matérias-primas não
estavam aparecendo no histórico de autorizações realizadas. <br>
<i class="fa-solid fa-diamond" style="color:mediumslateblue "></i> 
Novas medidas no campo tipo da requisição de serviço. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i> 
Melhoria nas tabelas das páginas autorização e cotação. <br>
<i class="fa-solid fa-circle-xmark" style="color:crimson;"></i> 
Corrigido Bug ao inserir aspas simples no campo de observação do item. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i> 
Zoom das páginas alterado de 100% para 90%. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i> 
Alterado tipo de campo dos campos de quantidade para comportar casas decimais. <br>
</div>


<div class="collapse" id="collapseVersao104" data-parent="#accordion">
<i class="fa-solid fa-diamond" style="color:mediumslateblue "></i> 
Opção de filtrar os pedidos de compra através do pedido Omie. <br>
<i class="fa-solid fa-diamond" style="color:mediumslateblue "></i> 
Nova funcionalidade ainda em desenvolvimento, apontamento de produção. <br>
<i class="fa-solid fa-diamond" style="color:mediumslateblue "></i> 
Acrescentado campo observação na parte de autorização. <br>
<i class="fa-solid fa-circle-xmark" style="color:crimson;"></i> 
Corrigido erro com valores decimais. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i> 
Atualizado diversos plugins. <br> <!-- MaskMoney -->
<i class="fa-solid fa-diamond" style="color:mediumslateblue "></i> 
Criada a possibilidade de editar a cotação, antes de ser aprovada. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i> 
Removido card de anexos caso não haja anexos na requisição. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i> 
Padronização e Fixação dos Botões no rodapé. <br>
</div>

<div class="collapse" id="collapseVersao105" data-parent="#accordion">
<i class="fa-solid fa-trash" style="color:slategray;"></i>
Removido a necessidade de escolher a categoria ao adicionar Materiais/Serviços a requisição. <br>
<i class="fa-solid fa-circle-xmark" style="color:crimson;"></i>
Corrigido bug onde a requisição era gerada sem itens, foi adicionado uma restrição. <br>
<i class="fa-solid fa-diamond" style="color:mediumslateblue "></i>
Criada Interface para associação dos roteiros a OP, na parte de apontamento. <br>
<i class="fa-solid fa-diamond" style="color:mediumslateblue "></i>
Adicionado informativo de serviços abertos de cada apontamento. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i> 
Os usuários que têm a autonomia para autorizar, ao criarem uma requisição, pularam uma etapa. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i> 
Otimização da página de Autorização. <br>
<i class="fa-solid fa-diamond" style="color:mediumslateblue "></i> 
Ao alterar senha, adicionado campo de confirmação de senha. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i>
Adicionado Máscara para CNPJ / CPF do fornecedor. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i> 
Ao adicionar um novo Material / Fornecedor, o usuário não perde os dados preenchidos anteriormente. <br>
<i class="fa-solid fa-circle-xmark" style="color:crimson;"></i>
Corrigido erro ao atualizar uma requisição. <br>
</div>


<div class="collapse" id="collapseVersao106" data-parent="#accordion">
<i class="fa-solid fa-circle-xmark" style="color:crimson;"></i>
Correção no acompanhamento da requisição, status encontrava-se incorreto. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i>
Melhoria na página de acompanhamento. <br>
<i class="fa-solid fa-diamond" style="color:mediumslateblue "></i>
A aprovação é realizada dependendo do valor da requisição. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i>
Pontuação correta nos campos de valores. <br>
<i class="fa-solid fa-circle-xmark" style="color:crimson;"></i>
Corrigido erro nas etapas e na situação mostrada na página de acompanhamento. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i>
Linha das tabelas em destaque, de acordo com o cursor do mouse. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i> 
Parte de upload de arquivos na requisição refeita. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i> 
Padronização dos nomes dos arquivos anexados as requisições<br>
<i class="fa-solid fa-diamond" style="color:mediumslateblue "></i> 
A requisição agora é salvada localmente, evitando perda dos dados ao longo do preenchimento. <br>
Os dados são removidos após o envio de cada requisição. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i> 
Realizados ajustes na página de anexos dos apontamentos. <br>
<i class="fa-solid fa-circle-xmark" style="color:crimson;"></i> 
Corrigido erro ao salvar uma aprovação. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i> 
Melhoria nos botões de aprovação e autorização. <br>
<i class="fa-solid fa-diamond" style="color:mediumslateblue "></i> 
Nova etapa para a requisição, após pedido de compra. <br>
<i class="fa-solid fa-diamond" style="color:mediumslateblue "></i> 
Parâmetros de inspeção para cada setor, disponível nos apontamentos. <br>
<i class="fa-solid fa-circle-xmark" style="color:crimson;"></i> 
Corrigido erro no campo dos colaboradores, na parte de apontamento. <br>
<i class="fa-solid fa-trash" style="color:slategray;"></i>
Removida predefinição de campos com valores. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i> 
Padronização dos títulos de cada card. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i> 
Melhoria nas páginas de visualizações, de todas as etapas. <br>
<i class="fa-solid fa-angle-double-up" style="color:green;"></i> 
Alteração da ordem dos cards de acordo com a etapa em que se encontram. <br>
<i class="fa-solid fa-circle-xmark" style="color:crimson;"></i> 
Corrigido número incorreto mostrado ao lado das etapas <br>
<i class="fa-solid fa-diamond" style="color:mediumslateblue "></i> 
Nova etapa no fluxo das requisições, etapa de recepção. <br>
<i class="fa-solid fa-circle-xmark" style="color:crimson;"></i> 
Erro de visualização na página de aprovações realizadas. <br>
</div>


<?php if($_settings->userdata('username') == 'Admin'): ?>


<div class="collapse" id="collapseVersao107" data-parent="#accordion">


</div>
<?php endif; ?>
</div> <!-- div acc -->
            </div> <!-- div container -->
    </div> <!-- card body -->
</div> <!-- card pagina -->