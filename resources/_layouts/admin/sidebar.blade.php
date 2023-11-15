<?php $menu_open = $menu_open ?? ''; ?>
<aside>

	{{-- @if($loginUser->canSee('books')) --}}
  <div class="sidebar-item-group @if($menu_open == 'books') open @endif">
    <div class="sidebar-item">Cursos</div>
    <div class="sidebar-subitems">
      <div class="sidebar-item"><a href="/admin/collections">Livres</a></div>
      <div class="sidebar-item"><a href="/admin/series">Pós-Graduações</a></div>
    </div>
  </div>

	<div class="sidebar-item-group @if($menu_open == 'books_other') open @endif">
		<div class="sidebar-item">Docentes</div>
		<div class="sidebar-subitems">
			<div class="sidebar-item"><a href="/admin/countryCities">Docentes</a></div>
    </div>
  </div>


	{{-- @endif --}}

	{{-- @if($loginUser->canSee('admin')) --}}
   <div class="sidebar-item-group @if($menu_open == 'admin') open @endif">
    <div class="sidebar-item">Admin</div>
    <div class="sidebar-subitems">
      <div class="sidebar-item"><a href="/admin/users">Utilizadores</a></div>
      <div class="sidebar-item"><a href="/admin/perms">Permissões</a></div>
    </div>
  </div>
	{{-- @endif --}}


</aside>
