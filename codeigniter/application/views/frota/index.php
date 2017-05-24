<div class="container">
  <div class="panel">
  <?php
    echo form_open('frota', array('class' => 'form-inline', 'method' => 'GET'));
    $data = array(
        'name'          => 'fabricante',
        'id'            => 'fabricante',
        'placeholder'   => 'Termo da pesquisa',
        'value'         => '',
        'class'         => 'form-control form-pesquisa'
    );
  ?>
  <div class="form-group">
  <?php echo form_label('Fabricante', 'fabricante'); ?>
  <?php echo form_input($data); ?>
  </div>

  <?php echo form_submit('submit', 'Pesquisar'); ?>
  <!--a href="<?php echo base_url(); ?>frota/create" class="btn btn-primary" role="button">Add</a-->
  <!--a href="#" class="btn btn-primary" role="button" data-toggle="modal" data-target="#create-book">Add</a-->

  <?php echo form_close(); ?>
  </div>
  <h2>Frota <?php echo '(' . $first_record . ' a ' . $last_record . ' de ' . $resultado_pesquisa_total . ')'; ?></h2>
  <div class="panel">
    <table class="table table-striped table-bordered  table-hover">
      <thead>
        <tr class="info">
          <th>id</th>
          <th>Fabricante</th>
          <th>Modelo</th>
          <th>Cor</th>
          <th>Matrícula</th>
          <th>Disponibilidade</th>
          <th>Acções</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($resultado_pesquisa as $viatura) { ?>
        <tr>
          <td><?php echo $viatura->id; ?></td>
          <td><?php echo $viatura->fabricante; ?></td>
          <td><?php echo $viatura->modelo; ?></td>
          <td><?php echo $viatura->cor; ?></td>
          <td><?php echo $viatura->matricula; ?></td>
          <td><?php echo $viatura->disponibilidade; ?></td>
          <td class="actions">

            <button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" >
              <span class="glyphicon glyphicon-pencil"></span>
            </button>

            <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button>
          </td>

        </tr>
          
        <?php } ?>
      </tbody>
    </table>
    <?php echo $pesquisa_pagination; ?>
  </div>
</div>


<!--- Modal -->
<div id="create-book" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add new book</h4>
        </div>

        <div class="modal-body modal-scroll">
          <?php echo $create_modal; ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>

  </div>
</div>

    
      
