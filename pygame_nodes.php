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
  ),
	'pygame_node_submission' => array(
		'name' => t('AI Game Submission'),
		'base' => 'pygame_node_submission',
		'description' => t('Node representing a user submission.'),
		'title_label' => t('Level Title'),
		'locked' => TRUE
	)
  );
}

function pygame_register_text_fields($bundle, $fields){
	foreach($fields as $f){
		field_create_field(array(
			'field_name' => $f['field_name'],
			'locked'=>TRUE,
			'type' => 'text_long'
		));
		field_create_instance(array(
			'entity_type' => 'node',
			'bundle' => $bundle,
			'field_name' => $f['field_name'],
			'label' => $f['label'],
			'widget' => array(
				'type' => 'text_textarea',
			),
			'display' => array(
				'full' => array(
					'type'=>'hidden',
					'label'=>'hidden'
				)
			)
		));
	}
}

function pygame_node_type_insert($content_type) {
	
	if ($content_type->type == 'pygame_node_level') {

		//Body field
		$body_instance = node_add_body_field($content_type, t('Level Description'));
		$body_instance['display']['full'] = array(
		  'label' => 'hidden',
		  'type' => 'text_default',
		);
		field_update_instance($body_instance);
		pygame_register_text_fields(
			'pygame_node_level',
			array(
				array(
					'field_name' => 'pygame_node_level_code_generate',
					'label' =>  t('Source code to generate the level.')
				),
				
				array(
					'field_name' => 'pygame_node_level_code_run',
					'label' =>  t('Source code to run the level.')
				)
			)
		);
	}else if ($content_type->type == 'pygame_node_submission') {

		//Body field
		$body_instance = node_add_body_field($content_type, t('Level Description'));
		$body_instance['display']['full'] = array(
		  'label' => 'hidden',
		  'type' => 'text_default',
		);
		field_update_instance($body_instance);
		pygame_register_text_fields(
			'pygame_node_level',
			array(
				array(
					'field_name' => 'pygame_node_level_code_generate',
					'label' =>  t('Source code to generate the level.')
				),
				
				array(
					'field_name' => 'pygame_node_level_code_run',
					'label' =>  t('Source code to run the level.')
				),
				
				array(
					'field_name' => 'pygame_node_level_code_submission',
					'label' =>  t('Source code submission.')
				),
				
				array(
					'field_name' => 'pygame_node_level_map',
					'label' =>  t('JSON representation of map.')
				),
				
				array(
					'field_name' => 'pygame_node_level_steps',
					'label' =>  t('JSON representation of steps.')
				)
			)
		);
		
	}else if($content_type->type=='pygame_node_tile'){
		field_create_field( array(
				'field_name' => 'pygame_node_tile_image',
				'locked'=>TRUE,
				'type' => 'image'
		));
		field_create_field( array(
				'field_name' => 'pygame_node_tile_set',
				'locked'=>TRUE,
				'type' => 'taxonomy_term_reference'
		));
		
		field_create_instance( array(
				'field_name' => 'pygame_node_tile_image',
				'entity_type' => 'node',
				'bundle' => 'pygame_node_tile',
				'label' => 'Tile Image',
				'description' => st('Tile image'),
				'widget' => array(
					'type' => 'image_image',
				)
		));
		
		field_create_instance( array(
				'field_name' => 'pygame_node_tile_set',
				'entity_type' => 'node',
				'bundle' => 'pygame_node_tile',
				'label' => 'Tile Set',
				'description' => st('Tile set'),
				'allowed_values' => array(
					'vocabulary'=>'pygame_tile_set',
					'parent'=>'0'
				)
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
            'template' =>  drupal_get_path('module', 'pygame') . '/node--pygame_node_level',
		),
		'pygame_level_display_initial' => array(
			'render element' => 'element'
		)
    );
    return $items;
}

function pygame_node_level_preprocess_node(&$vars) {
    $vars['theme_hook_suggestions'][] = 'node--pygame_node_level';
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