<!-- File: /app/View/Posts/edit.ctp -->

<?php echo $this->element('header');?>
<!-- テンプレート -->
<div class="container-fluid">
	<?php echo $this->element('teache_sidenav');?>
	<!-- メインコンテンツここから -->
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10">
		<!-- テンプレートおわり -->
		<div class="container-fluid">

<?php
// ここでタイプをファイル指定
echo $this->Form->create ( 'Post', array (
		'type' => 'file'
) );
echo $this->Form->input ( 'title', array (
		'label' => 'タイトル'
) );
echo $this->Form->input ( 'body', array (
		'rows' => '3'
) );
echo $this->Form->input ( 'id', array (
		'type' => 'hidden'
) );
// ここのinputの第一引数はモデルの項目名でないと判断されない。
echo $this->Form->input ( 'topic_id', array (
		'type' => 'select',
		'options' => $seletopics
) );

echo $this->Form->input ( 'File.0.attachment', array (
		'type' => 'file',
		'label' => 'アップロードファイル'
) );
echo $this->Form->input ( 'File.0.model', array (
		'type' => 'hidden',
		'value' => 'Post'
) );
// 作成者のIDを登録してしまおう。
echo $this->Form->input ( 'File.0.user_id', array (
		'type' => 'hidden',
		'value' => AuthComponent::user ( 'id' )
) );
echo $this->Form->end ( 'Save Post' );
?>
<p>
<?php
$i = 0;
foreach ( ( array ) $post ['File'] as $file ) :
	// 削除ボタン
	echo $file ['attachment'];
	echo $this->Form->create ( 'Post', array (
			'type' => 'file'
	) );
	echo $this->Form->input ( 'File.0.remove', array (
			'type' => 'checkbox',
			'label' => 'ファイルの削除'
	) );
	echo $this->Form->input ( 'File.0.id', array (
			'type' => 'hidden',
			'value' => $file ['id']
	) );
	echo $this->Form->end ( '削除' );
	$i ++;
endforeach
;
?>
</p>
<?php
echo $this->Html->link ( '一覧へ戻る', array (
		'action' => 'index'
) );
?>


</div>
	</div>
</div>
