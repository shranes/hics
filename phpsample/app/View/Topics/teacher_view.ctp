<!--  File: View/Topics/view.ctp -->

<?php echo $this->element('header');?>


<!-- テンプレート -->
<div class="container-fluid">
	<?php echo $this->element('teacher_sidenav');?>
	<!-- メインコンテンツここから -->
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10">
		<!-- テンプレートおわり -->

			<div class="container-fluid">
				<div class="panel panel-default">
					<div class="panel-body">
						<h1>
							<?php echo $rangerole['RangeRole']['range_name']?>
						</h1>

						<ul class="nav nav-tabs">
							<li><?php echo $this->Html->link('公開トピック', array('action' => 'common'));?>
							</li>
							<li><?php echo $this->Html->link('クラストピック', array('action' => 'homeroom'));?>
							</li>
							<li><?php echo $this->Html->link('個人用トピック', array('action' => 'personal'));?>
							</li>
						</ul>
						<table
							class="table table-striped table-bordered table-hover table-condensed">
							<tr>
								<th>id</th>
								<th>タイトル</th>
								<th>作成者</th>
								<th>作成者名</th>
								<th>Action</th>
								<th>delete</th>
								<th>Created</th>
							</tr>

							<?php foreach ($topics as $topic): ?>
							<tr>
								<td><?php echo $topic['Topic']['id'];?></td>
								<td><?php
								echo $this->Html->link ( $topic ['Topic'] ['topicname'], array (
										'teacher' => true,
										'controller' => 'posts',
										'action' => 'lists',
										$topic ['Topic'] ['id']
								) );
								?>
								</td>
								<td><?php echo $topic['User']['username'];?></td>
								<td><?php echo $topic['User']['userlname'].' '.$topic['User']['userfname']?>

								<td><?php echo $this->Html->link('編集', array('action' => 'edit', $topic['Topic']['id']));?>

								<td><?php
								// echo $this->Html->link('削除', array('action' => 'delete', $topic['Topic']['id']));
								echo $this->Form->postLink ( '削除', array (
								'action' => 'delete',
								$topic ['Topic'] ['id']
						), array (
								'confirm' => '本当によろしいですか？'
						) );
						?>

								<td><?php echo $topic['Topic']['created'];?></td>
							</tr>
							<?php endforeach;?>
							<?php unset($post);?>
						</table>


						<div>
							<?php echo $this->element('pagination');?>
						</div>

					</div>
					<p>
						<?php
						// 個人トピックスの場合は作成しない
						if ($rangerole ['RangeRole'] ['id'] != '3') {
							echo $this->Html->link ( 'トピックの作成', array (
									'action' => 'add',
									$rangerole ['RangeRole'] ['id']
							) );
						}
						?>

					</p>
				</div>
			</div>

	</div>
</div>
