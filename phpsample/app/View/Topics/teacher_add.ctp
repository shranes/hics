<!-- File:View/Topics/edit.ctp -->

<?php echo $this->element('header');?>

<!-- テンプレート -->
<div class="container-fluid">
	<?php echo $this->element('teacher_sidenav');?>
	<!-- メインコンテンツここから -->
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10">
		<!-- テンプレートおわり -->
		<div class="container-fluid">

			<p>
				<?php
				// ここはモデル名
				echo $this->Form->create ( 'Topic' );
				echo $this->Form->input ( 'Topic.topicname', array (
						'rows' => '2'
				) );
				echo $this->Form->input ( 'Topic.range_role_id', array (
						'type' => 'hidden',
						'value' => $rangerole ['RangeRole'] ['id']
				) );
				echo $this->Form->end ( '作成' );
				?>


			</p>
		</div>
	</div>
</div>
