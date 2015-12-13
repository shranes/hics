<?php echo $this->element('header');?>


<div class="container-fluid">
	<?php echo $this->element('sidenav');?>
	<!-- メインコンテンツここから -->
	<div class="col-md-10">
<?php echo $this->Form->create('Report', array('type'=>'file', 'enctype' => 'multipart/form-data')); ?>
	<fieldset>
		<legend><?php echo __('Add Report'); ?></legend>
	<?php
	echo $this->Form->input ( 'assignment_id', array (
			'type' => 'hidden',
			'value' => $assignment ['Assignment'] ['id']
	) );
	echo $this->Form->input ( 'user_id', array (
			'type' => 'hidden',
			'value' => AuthComponent::user ( 'id' )
	) );
	echo $this->Form->input ( 'comment' );
	// なぜか'File.0.attachment'から以下にすると動いた・・・
	echo $this->Form->input ( 'File.0.attachment', array (
			'type' => 'file',
			'label' => 'アップロードファイル',
			'multiple'
	) );
	echo $this->Form->input ( 'File.0.model', array (
			'type' => 'hidden',
			'value' => 'Report',
			'multiple'
	) );
	// 作成者のIDを登録してしまおう。
	echo $this->Form->input ( 'File.0.user_id', array (
			'type' => 'hidden',
			'value' => AuthComponent::user ( 'id' ),
			'multiple'
	) );

	echo $this->Form->button ( 'ファイルの追加', array (
			'type' => 'button',
			'id' => 'addfile'
	) );
?>



	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Reports'), array('action' => 'index')); ?></li>
	</ul>
</div>



<script>
// なんとしても動的にフォームを追加する（無理くり作成）
$(document).ready(function(){
	var $num = 0;

	// 仕方ないので０個目の削除ボタンを生成
	$('div.input.file').append('<button type="button" id="clear" value="File0Attachment">削除</button>');
	$('#addfile').click(function() {
		$num++;
		if ($num <= 4) {
			$('div.input.file').append('<input type="file" name="data[File][' + $num + '][attachment]" multiple="multiple" id="File' + $num + 'Attachment">');
			$('div.input.file').append('<button type="button" id = "clear" value="File' + $num + 'Attachment">削除</button>');
			$('div.input.file').after( '<input type="hidden" name="data[File][' + $num + '][model]" value="Report" multiple="multiple" id="File' +$num+ 'Model">'
					+ '<input type="hidden" name="data[File][' +$num+ '][user_id]" value="<?php echo AuthComponent::user('id');?>" multiple="multiple" id="File' +$num+ 'UserId">');
			console.log('addfile');
		} else {
			alert('ファイル添付は5個以内');
		}

	});
	$(document).on('click', '#clear',function() {
		$target = '#' + $(this).val();
		console.log($target);
		$($target).val('');
	});
});
</script>
