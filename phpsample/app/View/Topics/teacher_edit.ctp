<!-- File:View/Topics/edit -->

<?php echo $this->element('header');?>

<!-- テンプレート -->
<div class="container-fluid">
	<?php echo $this->element('teacher_sidenav');?>
	<!-- メインコンテンツここから -->
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10">
		<!-- テンプレートおわり -->
		<div class="container-fluid">

			<p>トピックの編集</p>
			<?php
			echo $this->Form->create ( 'Topic' );
			echo $this->Form->input ( 'topicname', array (
					'rows' => '3'
			) );
			echo $this->Form->input ( 'id', array (
					'type' => 'hidden'
			) );
			echo $this->Form->end ( '更新' );
			echo $this->Html->link ( 'トピック一覧', array (
					'action' => 'view'
			) );
			?>
			</div>
	</div>
</div>
