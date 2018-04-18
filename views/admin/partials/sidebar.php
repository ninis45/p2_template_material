<div class="nav-wrapper">
    <ul id="nav"
    class="nav"
    data-slim-scroll
    data-collapse-nav
    data-highlight-active>
        
        
       
	
	<li id="dashboard-link"><?php echo anchor('admin','<i class="zmdi zmdi-home"></i> <span class="ng-scope">'. lang('global:dashboard').'</span>', 'class="md-button md-ink-ripple top-link '.( ! $this->module ? 'current ' : '').'"') ?></li>

		<?php 

		// Display the menu items.
		// We have already vetted them for permissions
		// in the Admin_Controller, so we can just
		// display them now.
        
        //print_r($menu_items);
        if(isset($menu_items['Perfil']))
        {
            unset($menu_items['Perfil']);
        }
        
		foreach ($menu_items as $key => $menu_item)
		{
		    
            $icn=false;
           
			switch($key){
				case 'Configuraciones':
					$icn='<i class="zmdi zmdi-settings"></i>';
				break;
				case 'Usuarios':
					$icn='<i class="zmdi zmdi-accounts-alt"></i>';
				break;
                case 'Agregados':
					$icn='<i class="zmdi zmdi-apps"></i>';
				break;
                
                case 'Administracion':
					$icn='<i class="zmdi zmdi-balance"></i>';
				break;
                
                case 'Datos':
					$icn='<i class="zmdi zmdi-storage"></i>';
				break;
                
                case 'Perfil':
					$icn='<i class="zmdi zmdi-account"></i>';
				break;
                
                case 'Contenido':
					$icn='<i class="zmdi zmdi-globe"></i>';
				break;
                
                case 'Catalogos':
					$icn='<i class="zmdi zmdi-folder"></i>';
				break;
                
                
                
				default:
					$icn='<i class="zmdi zmdi-pages ng-scope"></i>';
				break;
				

			}
			if (is_array($menu_item))
			{
				echo '<li><a href="'.current_url().'#" class="top-link" md-button aria-label="meanu">'.$icn.lang_label($key).'</a><ul>';

				foreach ($menu_item as $lang_key => $uri)
				{
					echo '<li><a href="'.site_url($uri).'" class="" md-button aria-label="meanu">'.lang_label($lang_key).'</a></li>';

				}

				echo '</ul></li>';

			}
			elseif (is_array($menu_item) and count($menu_item) == 1)
			{
				foreach ($menu_item as $lang_key => $uri)
				{
					echo '<li><a href="'.site_url($menu_item).'" class="top-link no-submenu" md-button aria-label="meanu">'.$icn.lang_label($lang_key).'</a></li>';
				}
			}
			elseif (is_string($menu_item))
			{
				echo '<li><a href="'.site_url($menu_item).'" class="top-link no-submenu" md-button aria-label="meanu">'.$icn.lang_label($key).'</a></li>';
			}

		}
	
		?>

    </ul>
</div>