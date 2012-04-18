<?php
	$me_array = $this->Session->read('Auth.User');
	$me = $me_array['id'];

	echo $form->create('Topic', array('url'=>
				array('controller'=>'topics', 'action' => 'create'),
				'name' => 'f'
			));
	echo "<div style='text-align:left; margin-bottom:15px; border-bottom:solid 10px #C6D5FD'>".$html->image('/img/basic/pencil/pencil_48.png');
	echo "<span style='font-size:200%; color:#333; margin-left:10px;'>Create Topic</span>";
	echo "</div>";
	echo "<div style='font-size:200%; color:#004b75; text-align:left; margin-bottom:7px; margin-top:10px;'>Title</div>";
	echo "<div>".$form->textarea('title', array('cols'=>'30', 'rows'=>'3','label'=>false, 'style'=>'font-size:200%; width:100%;','onfocus'=>'this.value=""','onblur'=>'if(this.value=="") this.value="Topic Title"'))."</div>";
	echo "<div style='font-size:120%; color:#333; text-align:right; margin-bottom:15px'>Max 100 characters</div>";
	echo "<div style='font-size:200%; color:#004b75; text-align:left; margin-bottom:7px;'>The Topic Story ";
	echo "<span style='font-size:60%; color:#aaa; text-align:left;'>Why/How you come up with this topic? Tell us your story.</span>";
	echo "</div>";
	echo $form->textarea('body', array('cols'=>'50', 'rows'=>'15','label'=>false, 'div'=>false, 'style'=>'font-size:200%; width:100%;'));
	echo "<div style='font-size:120%; color:#333; text-align:right;'>Max 1000 characters</div>";
	echo "<div style='font-size:200%; color:#004b75; text-align:left; margin-bottom:15px;'>Category</div>";
/*
	$options=array(
		'1'=>'Love',
		'2'=>'Personal',
		'3'=>'Entertainment',
		'4'=>'Life',
		'5'=>'Work');
*/
	echo "<div style='text-align:left;margin-top:7px;'>";
	echo $this->Form->select('category',$options,null,array('empty' => false));
	echo "</div>";
	echo $form->submit('/img/basic/post0.png', array('type'=>'submit','name'=>'post','value'=>'post','style'=>'margin-top:10px'));

	echo "<br /><br />";
?>
