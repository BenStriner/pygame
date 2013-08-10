<?php

/**
 * Implements hook_node_info().
 *
 * We use hook_node_info() to define our node content type.
 */
function pygame_node_info() {
  // We define the node type as an associative array.
  return array(
    'pygame_node_level' => array(
      'name' => t('AI Game Level'),
      // 'base' tells Drupal the base string for hook functions.
      // This is often the module name; if base is set to 'mymodule',
      // Drupal would call mymodule_insert() or similar for node
      // hooks. In our case, the base is 'node_example'.
      'base' => 'pygame_node_level',
      'description' => t('Node representing a single level.'),
      'title_label' => t('Level Title'),
      // We'll set the 'locked' attribute to TRUE, so users won't be
      // able to change the machine name of our content type.
      'locked' => TRUE,
    ),
	'pygame_node_tile' => array(
		'name' => t('AI Game Tile'),
		'base' => 'pygame_node_tile',
		'description' => t('Node representing a single tile.'),
		'title_label' => t('Tile Name'),
		'locked' => TRUE,
  )
  );
}


function pygame_node_type_insert($content_type) {
	
	if ($content_type->type == 'pygame_node_level') {
		// First we add the body field. Node API helpfully gives us
		// node_add_body_field().
		// We'll set the body label now, although we could also set
		// it along with our other instance properties later.
		$body_instance = node_add_body_field($content_type, t('Level Description'));

		// Add our example_node_list view mode to the body instance
		// display by instructing the body to display as a summary
		$body_instance['display']['full'] = array(
		  'label' => 'hidden',
		  'type' => 'text_summary_or_trimmed',
		);

		// Save our changes to the body field instance.
		field_update_instance($body_instance);

		// Create all the fields we are adding to our content type.
		foreach (_pygame_node_level_installed_fields() as $field) {
		  field_create_field($field);
		}

		// Create all the instances for our fields.
		foreach (_pygame_node_level_installed_instances() as $instance) {
		  $instance['entity_type'] = 'node';
		  $instance['bundle'] = 'pygame_node_level';
		  field_create_instance($instance);
		}
		
	}else if($content_type->type=='pygame_node_tile'){
		field_create_field( array(
		//	'pygame_node_tile_image' => array(
				'field_name' => 'pygame_node_tile_image',
				'locked'=>TRUE,
				'type' => 'image'
			//)
		));
		field_create_field( array(
	//		'pygame_node_tile_set' => array(
				'field_name' => 'pygame_node_tile_set',
				'locked'=>TRUE,
				'type' => 'taxonomy_term_reference'
		//	)
		));
		
		field_create_instance( array(
//			'pygame_node_tile_image' => array(
				'field_name' => 'pygame_node_tile_image',
				'entity_type' => 'node',
				'bundle' => 'pygame_node_tile',
				'label' => 'Tile Image',
				'description' => st('Tile image'),
				'widget' => array(
					'type' => 'image_image',
				)
//			)
		));
		
		field_create_instance( array(
//			'pygame_node_tile_set' => array(
				'field_name' => 'pygame_node_tile_set',
				'entity_type' => 'node',
				'bundle' => 'pygame_node_tile',
				'label' => 'Tile Set',
				'description' => st('Tile set'),
				'allowed_values' => array(
					'vocabulary'=>'pygame_tile_set',
					'parent'=>'0'
				)
	//		)
		));	
	}
}

/**
 * Implement hook_form().
 *
 * Drupal needs for us to provide a form that lets the user
 * add content. This is the form that the user will see if
 * they go to node/add/node-example.
 *
 * You can get fancy with this form, or you can just punt
 * and return the default form that node_content will provide.
 */
function pygame_node_level_form($node, $form_state) {
	return node_content_form($node, $form_state);
}
function pygame_node_tile_form($node, $form_state) {
	return node_content_form($node, $form_state);
}

function pygame_theme($existing, $type, $theme, $path) {
    $items = array(
        'node--pygame_node_level' => array(
            'template' =>  drupal_get_path('module', 'pygame_node_level') . '/node--pygame_node_level',
            'variables' => array('node' => (object)array())
        )
    );
    return $items;
}

function pygame_node_level_preprocess_node(&$vars) {
    $variables['theme_hook_suggestions'][] = 'node--pygame_node_level';
}

function _pygame_node_level_installed_fields() {
	return array(
		'pygame_node_level_code_generate' => array(
			'field_name' => 'pygame_node_level_code_generate',
			'locked'=>TRUE,
			'type' => 'text_long'
		),
		'pygame_node_level_code_run' => array(
			'field_name' => 'pygame_node_level_code_run',
			'locked'=>TRUE,
			'type' => 'text_long'
		)
	);
}

function _pygame_node_level_installed_instances() {
  return array(
    'pygame_node_level_code_generate' => array(
      'field_name' => 'pygame_node_level_code_generate',
      'label' => t('Source code to generate the level.'),
      'widget' => array(
        'type' => 'text_textarea',
      )
    ),
	
    'pygame_node_level_code_run' => array(
      'field_name' => 'pygame_node_level_code_run',
      'label' => t('Source code to run the level.'),
      'widget' => array(
        'type' => 'text_textarea',
      )
    )
	);
}

/*
function pygame_field_widget_info(){
	return array(
		'pygame_widget_size'=>array(
			'label'=>'Level Size',
			'description'=>'Width and Height',
			'field types'=>array(''),
			
}

function pygame_element_info() {
 // $types['pygame_field_size'] = array(
 return array('pygame_field_size' =>
    '#input' => TRUE,
    '#element_validate' => array('pygame_field_size_validate'),
    '#autocomplete_path' => FALSE,
    '#process' => array('pygame_field_size_process'),
    '#theme' => 'textfield',
    '#theme_wrappers' => array('form_element'),
    '#maxlength' => 16
  );
}

function pygame_field_size_validate(){
}
function pygame_field_size_process(){
}
*/