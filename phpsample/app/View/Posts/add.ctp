<!--  File: /app/View/Posts/add.ctp -->

<?php echo $this->element('header');?>



<div class="container-fluid">
	<?php echo $this->element('sidenav');?>
	<!-- メインコンテンツここから -->
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10" >

		<h1>Add Post</h1>
		<?php
		echo $this->Form->create ( 'Post', array (
				'type' => 'file'
		) );
		echo $this->Form->input ( 'title' );
		echo $this->Form->input ( 'body', array (
				'rows' => '3'
		) );
		echo $this->Form->input ( 'topic_id', array (
				'type' => 'select',
				'options' => $seletopics,
				'selected' => $topic_id
		) );
		// なぜか'File.0.attachment'から以下にすると動いた・・・
		echo $this->Form->input ( 'File.0.attachment', array (
				'type' => 'file',
				'label' => 'アップロードファイル',
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
		// echo $this->Form->select('トピックス', $seletopics);
		echo $this->Form->end ( '記事を投稿' );
		?>
	</div>
</div>