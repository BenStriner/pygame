<?php

//Adds content when viewing a level
function pygame_node_level_view($node, $view_mode, $langcode){
	if($view_mode == 'full'){
		$node->content['pygame_leveldisplay']=array(
			'#theme' => 'pygame_leveldisplay_initial',
			'node_id' => $node->nid
		);
		$state = array('node_id' => $node->nid);
		$node->content['pygame_codeform']=drupal_build_form('pygame_node_level_codeform', $state);
	}
}

//Initial view of level
function pygame_leveldisplay_initial($variables){
//	$arena = pygame_get_arena();
//	return $arena->render();
	return "<p>Node ID Testing is ".$variables['node_id']."</p>";
}

//Returns the form for entering code
function pygame_node_level_codeform($form, &$form_state) {
  //$form = array();
  $form['sourcecode'] = array(
    '#type' => 'textarea'
	);
  $form['submitbutton'] = array(
	'#type' => 'submit',
	'#value' => 'Run Code',
	'#ajax' => array(
		'callback' => 'pygame_node_level_form_run_callback',
     )
	);
  $form['node_id'] = array(
	'#type'=>'hidden',
	'#value'=>$form_state['node_id'],
	);
  $form['#ajax'] = array(
      'callback' => 'pygame_node_level_form_run_callback',
     );
	$form['#attached']['js'][] = drupal_get_path('module','pygame').'/js/pygame.js';
	$form['#attached']['css'][] = drupal_get_path('module','pygame').'/css/pygame.css';
  return $form;
}

class AIArena{
	public $height = 20;
	public $width = 20;
	public $player_x = 10;
	public $player_y = 10;
	public function to_script(){
		return "";
	}
	public function render(){
	
	
		$ret = "<div class='csstable'>";
		for($y=0;$y<$this->height;$y++){
			$ret .= "<div class='csstr'>";
			for($x=0;$x<$this->width;$x++){
				//$ret .= "<div class='csstd'>";
				if($this->player_x == $x && $this->player_y == $y){
					$ret .= "<div class='csstd' style='background-image:url(/sites/all/themes/pygame_theme/sprite.jpg)'><br/></div>";
//					$ret .= '<img src="/sites/all/themes/pygame_theme/sprite.jpg" class="arenatile" />';
				}else{
					$ret .= "<div class='csstd' style='background-image:url(/sites/all/themes/pygame_theme/background.jpg)'><br/></div>";
					//$ret .= '<img src="/sites/all/themes/pygame_theme/background.jpg" class="arenatile" />';
				}
				//$ret .= "</div>";
			}
			$ret .= "</div>";
		}
		$ret .= "</div>";
		return $ret;	
	}
}

function pygame_get_arena(){
	return new AIArena();
}

//Called when user enters code and hits run
//Returns AJAX commands to animate the level
function pygame_node_level_form_run_callback($form, $form_state){
//	return "<p>test return value</p>";
//return print_r($form_state,true);

		$ajax_commands = array();

$code = $form_state['input']['sourcecode'];

$arena = pygame_get_arena();

$output = pygame_run_script_with_input($code, $arena->to_script());

$steps = array();

$steps[] = $arena->render();
foreach(preg_split("/((\r?\n)|(\r\n?))/", $output) as $line){
    // do stuff with $line
	if(preg_match('/up/i', $line)){
		$arena->player_y -= 1;
	}else{
	if(preg_match('/left/i', $line)){
		$arena->player_x -= 1;
	}else{
	if(preg_match('/down/i', $line)){
		$arena->player_y += 1;
	}else{
	if(preg_match('/right/i', $line)){
		$arena->player_X += 1;
	}
	}
	}
	}
	$steps[] = $arena->render();
}
$res = '<div id="results-div">';
$res .= join("",$steps);
$res .= '</div';
//<p>'.$code.'</p><p>'.$cmd.'</p><p>'.$output.'</p>


	$ajax_commands[] = ajax_command_replace('#results-div', $res);
	$ajax_commands[] = ajax_command_invoke(NULL, 'pygame_slider', array($res));
		//return ajax_render($ajax_commands);
		return array(
			'#type' => 'ajax',
			'#commands' => $ajax_commands
			);
//return '<div id="results-div">'.$res.'</div>';
}

/*

Code for running python sandbox

*/

function pygame_run_script($code){
	$file = file_save_data($code);
	$path = drupal_realpath($file->uri);
	$cmd = '"C:\\Python27\\python.exe" "'.$path.'"';
	$output = shell_exec($cmd);
	return $output;
}
function pygame_run_script_with_input($code, $input){
	$file = file_save_data($code);
	$ifile = file_save_data($input);
	$path = drupal_realpath($file->uri);
	$ipath = drupal_realpath($ifile->uri);
	$cmd = '"C:\\Python27\\python.exe" "'.$path.'" < "'.$ipath.'"';
	$output = shell_exec($cmd);
	return $output;
}