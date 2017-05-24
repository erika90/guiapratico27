<div class="container-fluid form-container">
  <?php echo form_open('frota/create', array('class' => 'form-horizontal', 'id' => 'form-new-book')); ?>
  <!--form id="form-new-book" method="post" class="form-horizontal col-md-12"-->
  <fieldset>
    <!--legend>Add New Book</legend-->
    <div class="">
      <!--?php echo validation_errors(); ?-->
    </div>
    <div class="form-group">
      <label for="title" class="col-lg-2 control-label">Title</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" id="title" name="title" placeholder="Book title" value="<?php echo set_value('title'); ?>">
        <?php echo form_error('title'); ?>
      </div>
    </div>
    <div class="form-group">
      <label for="subtitle" class="col-lg-2 control-label">Subtitle</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Book subtitle" value="<?php echo set_value('subtitle'); ?>">
      </div>
    </div>
    <div class="form-group">
      <label for="isbn" class="col-lg-2 control-label">ISBN</label>
      <div class="col-lg-10">
        <input type="number" class="form-control" id="isbn" name="isbn" placeholder="ISBN" value="<?php echo set_value('isbn'); ?>">
        <?php echo form_error('isbn'); ?>
      </div>
    </div>
    <div class="form-group">
      <label for="pubDate" class="col-lg-2 control-label">Publication Date</label>
      <div class="col-lg-10">
        <input type="date" class="form-control" id="pubDate" name="pubDate" value="<?php echo set_value('pubDate'); ?>">
        <?php echo form_error('pubDate'); ?>
      </div>
    </div>
    <div class="form-group">
      <label for="editor" class="col-lg-2 control-label">Editor</label>
      <div class="col-lg-10">
        <select class="form-control" id="editor" name="editor">
          <?php foreach ($editoras as $editora) { ?>
            <option <?php echo set_select('editor', $editora->id); ?> value="<?php echo $editora->id; ?>"><?php echo $editora->nome; ?></option>
          <?php } ?>
        </select>
        <?php echo form_error('editor'); ?>
      </div>
    </div>
    <div class="form-group">
      <label for="autores" class="col-lg-2 control-label">Author</label>
      <div class="col-lg-10">
        <select multiple="" class="form-control" id="autor" name="autores[]">
          <?php foreach ($autores as $autor) { ?>
            <option <?php echo set_select('autores[]', $autor->id); ?> value="<?php echo $autor->id; ?>"><?php echo $autor->nome; ?></option>
          <?php } ?>
        </select>
        <?php echo form_error('autores[]'); ?>
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="reset"  class="btn btn-default">Cancel</button>
        <!--button type="submit" class="btn btn-primary">Save</button-->
        <button name="submit" type="submit" class="btn btn-primary">Save</button>
      </div>
    </div>
  </fieldset>

<?php echo form_close(); ?>
</div>

<script>
  $( function(){

    $('#form-new-book').submit(function(e) {
      e.preventDefault(); 
      var formDataa = new FormData($('#form-new-book'));
      $.ajax({
        type : "POST",
        dataType:'json',
        data : $( "#form-new-book" ).serialize(),
        url: '<?php echo base_url("frota/createAjax/")?>', 
        cache : false,
        success : function(response){
          if(!response.success){
            $("#create-book .modal-body").html(response.html);
          }else{
            $('#create-book').modal('toggle');
            $('#form-new-book').trigger('reset');
          }
        }
      });        
      return false;
    }); 
  });
</script>