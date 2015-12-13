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


					<h2>
						<?php echo __('Subject'); ?>
					</h2>
					<dl>
						<dt>
							<?php echo __('Id'); ?>
						</dt>
						<dd>
							<?php echo h($subject['Subject']['id']); ?>
							&nbsp;
						</dd>
						<dt>
							<?php echo __('Title'); ?>
						</dt>
						<dd>
							<?php echo h($subject['Subject']['title']); ?>
							&nbsp;
						</dd>
						<dt>
							<?php echo __('Body'); ?>
						</dt>
						<dd>
							<?php echo h($subject['Subject']['body']); ?>
							&nbsp;
						</dd>
						<dt>
							<?php echo __('Homeroom Id'); ?>
						</dt>
						<dd>
							<?php echo h($subject['Subject']['homeroom_id']); ?>
							&nbsp;
						</dd>
						<dt>
							<?php echo __('Created'); ?>
						</dt>
						<dd>
							<?php echo h($subject['Subject']['created']); ?>
							&nbsp;
						</dd>
						<dt>
							<?php echo __('Modified'); ?>
						</dt>
						<dd>
							<?php echo h($subject['Subject']['modified']); ?>
							&nbsp;
						</dd>
					</dl>
				</div>
			</div>
		</div>
		<div class="actions">
			<h3>
				<?php echo __('Actions'); ?>
			</h3>
			<ul>
				<li><?php echo $this->Html->link(__('Edit Subject'), array('action' => 'edit', $subject['Subject']['id'])); ?>
				</li>
				<li><?php echo $this->Form->postLink(__('Delete Subject'), array('action' => 'delete', $subject['Subject']['id']), array(), __('Are you sure you want to delete # %s?', $subject['Subject']['id'])); ?>
				</li>
				<li><?php echo $this->Html->link(__('List Subjects'), array('action' => 'index')); ?>
				</li>
				<li><?php echo $this->Html->link(__('New Subject'), array('action' => 'add')); ?>
				</li>
			</ul>
		</div>

	</div>
</div>
</div>
