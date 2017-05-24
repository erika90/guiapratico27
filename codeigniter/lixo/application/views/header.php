<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo base_url();?>">BravaCar</a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li <?php echo setMenuActiveItem($active_menu=='home')?>>
          <a href="<?php echo base_url('publico');?>">Home</a>
        </li>
        <li <?php echo setMenuActiveItem($active_menu=='sobre')?>>
          <a href="<?php echo base_url('publico/sobre');?>">Sobre</a>
        </li>
        <!--
        <li <?php echo setMenuActiveItem($active_menu=='frota')?>>
          <a href="<?php echo base_url('frota');?>">Frota Automóvel</a>
        </li>
      -->
      <li class="dropdown" <?php echo setMenuActiveItem($active_menu=='frota')?>>
        <a href="<?php echo base_url('frota');?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Frota Automóvel <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="<?php echo base_url('frota');?>">Pesquisa</a></li>
          <li><a href="<?php echo base_url('frota/novo');?>">Adicionar Novo</a></li>
        </ul>
      </li>
      <li <?php echo setMenuActiveItem($active_menu=='contacto')?>>
        <a href="<?php echo base_url('publico/contacto');?>">Contacto</a>
      </li>
    </ul>
  </div><!--/.nav-collapse -->
</div>
</nav>