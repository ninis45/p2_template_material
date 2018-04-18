<?php echo form_open(uri_string()); ?>

<div class="form_inputs" ng-controller="InputCtrl">



		<div class="form-group">
			<label for="field_name"><?php echo lang('streams:label.field_name');?> <span>*</span></label>
			
				<?php

				if (substr($field->field_name, 0, 5) === 'lang:')
				{
					echo '<p><em>'.$this->lang->line(substr($field->field_name, 5)).'</em></p>';
					echo form_hidden('field_name', $field->field_name);
				}
				else
				{
					echo form_input('field_name', $field->field_name, 'ng-init="field_name=\''.$field->field_name.'\'" ng-model="field_name" class="form-control" maxlength="60" id="field_name" autocomplete="off"');
				}

				?>

		</div>

		<?php if (property_exists($field, 'field_slug')): ?>
		
		<div class="form-group">
			<label for="field_slug"><?php echo lang('streams:label.field_slug');?> <span>*</span></label>
            <slug from="field_name" to="field_slug" >
			<?php echo form_input('field_slug', $field->field_slug, 'ng-model="field_slug" class="form-control" maxlength="60" id="field_slug"'); ?>
            </slug>
            <p class="help-block"><?php echo lang('global:slug_instructions'); ?></p>
    	</div>

		<?php endif; ?>

		<?php

		if (property_exists($field, 'is_required')) $is_required = ($field->is_required == 'yes') ? true : false;
		if (property_exists($field, 'is_unique')) $is_unique = ($field->is_unique == 'yes') ? true : false;

		?>

		<?php if (property_exists($field, 'is_required')): ?>

		<div class="form-group">
			
            <label class="checkbox-inline">
			 <?php echo form_checkbox('is_required', 'yes', $is_required, 'id="is_required"');?>
             <?php echo lang('streams:label.field_required');?>
            </label>
		</div>

		<?php endif; ?>

		<?php if (property_exists($field, 'is_unique')): ?>

		<div class="form-group">
			
			<label class="checkbox-inline">
                <?php echo form_checkbox('is_unique', 'yes', $is_unique, 'id="is_unique"'); ?>
                <?php echo lang('streams:label.field_unique');?>    
            </label>
		</div>

		<?php endif; ?>

		<?php if (property_exists($field, 'instructions')): ?>

		<div class="form-group">
			<label for="field_instructions"><?php echo lang('streams:label.field_instructions');?></label>
			
                <?php echo form_textarea('instructions', $field->instructions, 'id="field_instructions" class="form-control"');?>
		      <p class="help-block"><?php echo lang('streams:instr.field_instructions');?></p>
        </div>

		<?php endif; ?>

		<?php if ($allow_title_column_set): ?>
		<div class="form-group">
			<label for="title_column"><?php echo lang('streams:label.make_field_title_column');?></label>
			<label class="checkbox-inline"><?php echo form_checkbox('title_column', 'yes', $title_column_status, 'id="title_column"');?></label>
		</div>
		<?php endif; ?>

		<?php
		
			// We send some special params in an edit situation
			$ajax_url = 'streams/ajax/build_parameters';	
		
			if($this->uri->segment(4) == 'edit'):
			
				$ajax_url .= '/edit/'.$current_field->id;
			
			endif;
		
		?>
		
		<div class="form-group">
			<label for="field_type"><?php echo lang('streams:label.field_type'); ?> <span>*</span></label>
			<?php echo form_dropdown('field_type', $field_types, $field->field_type, 'class="form-control" ng-model="data.field_type" ng-init="data.field_type=\''.$field->field_type.'\'" data-placeholder="'.lang('streams:choose_a_field_type').'" id="field_type"'); ?>
		</div>
	   
		<div id="parameters" <?=($this->method=='create')?'ng-bind-html="parameters':''?>>
		
		<?php if( $method == "edit" or isset($current_type->custom_parameters) ): ?>
		
		<?php
		
		$data = array();
		
		$data['count'] = 0;
				
		if( isset($current_type->custom_parameters) ):
			
			foreach( $current_type->custom_parameters as $param ):

				// Sometimes these values may not be set. Let's set
				// them to null if they are not.
				$value = (isset($current_field->field_data[$param])) ? $current_field->field_data[$param] : null;
						
				if (method_exists($current_type, 'param_'.$param))
				{
					$call = 'param_'.$param;
					
					$input = $current_type->$call($value);

					if (is_array($input))
					{
						$data['input'] 			= $input['input'];
						$data['instructions']	= $input['instructions'];
					}
					else
					{
						$data['input'] 			= $input;
						$data['instructions']	= null;
					}

					$data['input_name']		= $this->lang->line('streams:'.$this->type->types->{$current_field->field_type}->field_type_slug.'.'.$param);
				}
				elseif (method_exists($parameters, $param))
				{			
					$data['input'] 			= $parameters->$param($value);
					$data['input_name']		= $this->lang->line('streams:'.$param);
				}
				
				$data['input_slug']		= $param;
					
				echo $this->load->view('streams_core/extra_field', $data, TRUE);
				
				$data['count']++;
				unset($value);
			
			endforeach;
		
		endif;
	
		?>
		
		<?php endif; ?>
		
		</div>
	

		<div class="divider"></div>
		<div class="buttons">
    		<button type="submit" name="btnAction" value="save" class="btn btn-success"><span><?php echo lang('buttons:save'); ?></span></button>	
    		<?php if ($cancel_uri): ?>
        		<a href="<?php echo site_url($cancel_uri); ?>" class="btn gray cancel"><?php echo lang('buttons:cancel'); ?></a>
        	<?php endif; ?>
    	</div>
	
<?php echo form_close();?>
