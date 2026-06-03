<?php $paginaAtiva ??= ''; ?>
<div id="nav-header">
  <ul id="nav-pages">
    <li><a href="entradas"   <?= $paginaAtiva === 'entradas'   ? 'class="ativo"' : '' ?>>Entradas</a></li>
    <li><a href="saidas-var" <?= $paginaAtiva === 'saidas-var' ? 'class="ativo"' : '' ?>>Saídas Variáveis</a></li>
    <li><a href="saidas-fix" <?= $paginaAtiva === 'saidas-fix' ? 'class="ativo"' : '' ?>>Saídas Fixas</a></li>
  </ul>
</div>
