<!--  File: View/Topics/view.ctp -->

<?php echo $this->element('header');?>


<!-- テンプレート -->
<div class="container-fluid">
	<?php echo $this->element('sidenav');?>
	<!-- メインコンテンツここから -->
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10">
		<div class="container-fluid">
			<!-- テンプレートおわり -->

			<h1><?php echo $rangerole['RangeRole']['range_name']?></h1>

			<ul class="nav nav-tabs">
				<li><?php echo $this->Html->link('公開トピック', array('action' => 'common'));?></li>
				<li><?php echo $this->Html->link('クラストピック', array('action' => 'homeroom'));?></li>
				<li><?php echo $this->Html->link('個人用トピック', array('action' => 'personal'));?></li>
			</ul>
			<div class="container-fluid">
				<table
					class="table table-striped table-bordered table-hover table-condensed">
					<tr>
						<th>タイトル</th>
						<th>作成者</th>
						<th>更新日</th>
					</tr>

				<?php foreach ($topics as $topic): ?>
				<tr>
						<td><?php
					echo $this->Html->link ( $topic ['Topic'] ['topicname'], array (
							'controller' => 'posts',
							'action' => 'lists',
							$topic ['Topic'] ['id']
					) );
					?>
					</td>
						<td><?php echo $topic['User']['username'];?></td>
						<td><?php echo $topic['Topic']['modified'];?></td>
					</tr>
				<?php endforeach;?>
				<?php unset($post);?>
			</table>
			</div>

		<div>
		<?php echo $this->element('pagination')?>
		</div>

		</div>
	</div>
</div>

