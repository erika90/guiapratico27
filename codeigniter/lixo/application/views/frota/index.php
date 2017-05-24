<div class="container">
  <div class="panel">
  <?php
    echo form_open('books', array('class' => 'form-inline', 'method' => 'GET'));
    $data = array(
        'name'          => 'title',
        'id'            => 'title',
        'placeholder'   => 'Titulo do livro a pesquisar',
        // 'value'         => set_value('title'),
        'value'         => $title,
        'class'         => 'form-control form-search-title'
    );
  ?>
  <div class="form-group">
  <?php echo form_label('Titulo', 'title'); ?>
  <?php echo form_input($data); ?>
  </div>
  <?php
    $data = array(
        'name'          => 'author',
        'id'            => 'author',
        'placeholder'   => 'Autor do livro a pesquisar',
        // 'value'         => set_value('author'),
        'value'         => $author,
        'class'         => 'form-control form-search-author'
    );
  ?>
  <div class="form-group">
  <?php echo form_label('Autor', 'author'); ?>
  <?php echo form_input($data); ?>
  </div>

  <?php echo form_submit('submit', 'Pesquisar'); ?>
  <!--a href="<?php echo base_url(); ?>books/create" class="btn btn-primary" role="button">Add</a-->
  <a href="#" class="btn btn-primary" role="button" data-toggle="modal" data-target="#create-book">Add</a>

  <?php echo form_close(); ?>
  </div>
  <h2>Book list <?php echo '(' . $first_record . ' a ' . $last_record . ' de ' . $search_results_count . ')'; ?></h2>
  <div class="panel">
    <table class="table table-striped table-bordered  table-hover">
      <thead>
        <tr class="info">
          <th>id</th>
          <th>Title</th>
          <th>Authors</th>
          <th>Editor</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($search_results as $livro) { ?>
        <tr>
          <td><?php echo $livro->id; ?></td>
          <td><?php echo $livro->titulo; ?></td>
          <td><?php $autores = explode(",", $livro->autores);
              foreach ($autores as $autor) {
                echo '<span class="label label-primary">' . $autor  . '</span> ';
              }
          ?></td>
          <td><?php echo $livro->editor; ?></td>
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
    <?php echo $search_pagination; ?>
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

    
      
