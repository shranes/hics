<!-- file: /app/View/Elements/header.ctp -->

<?php echo $this->Html->css('sidenav.css');?>

<div id="sidenav">
	<div class="row">
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">

			<!-- 4列をサイドメニューに割り当て -->
			<ul class="nav nav-sidebar">
				<!-- 4列をサイドメニューに割り当て -->
				<div class="well">
					<li>
						<div class="panel panel-primary hidden-xs hidden-sm">
							<div class="panel-heading">
								<div class="panel-title">アカウント情報</div>
							</div>
							<div class="panel-body">
								<ul class="list-unstyled">
									<li><?php echo __('ユーザー名'); ?>: <?php echo AuthComponent::user ( 'userlname' ).' '.AuthComponent::user ( 'userfname' );; ?>

									</li>

									<li><?php echo __('クラス名'); ?>: <?php echo h($user['Homeroom']['homeroom_name']); ?>

									</li>

								</ul>
							</div>
						</div>
					</li>
					<ul class="nav nav-pills nav-stacked">
						<li><?php echo $this->Html->link($this->Html->tag ( 'span', '', array (
								'class' => 'glyphicon glyphicon-th-list'
						) ) . ' ' . 'トピック'
								, array('controller' => 'topics', 'action' => 'common'), array (
								'escape' => false,
								'class' => 'btn btn-default',
								'role' => 'button'
						) );?>
						</li>
						<li><?php
						echo $this->Html->link (
								$this->Html->tag ( 'span', '', array (
								'class' => 'glyphicon glyphicon-user'
						) ) . ' ' . '生徒一覧'
								, array (
								'teacher' => true,
								'controller' => 'users',
								'action' => 'index'
						), array (
								'escape' => false,
								'class' => 'btn btn-default',
								'role' => 'button'
						) );

						// echo $this->Html->link ( '生徒一覧', array (
						// 'teacher' => true,
						// 'controller' => 'users',
						// 'action' => 'index'
						// ) );
						?>
						</li>
						<li><?php

						echo $this->Html->link ( $this->Html->tag ( 'span', '', array (
								'class' => 'glyphicon glyphicon-file'
						) ) . ' ' . 'ファイル', array (
								'teacher' => true,
								'controller' => 'files',
								'action' => 'filelist'
						), array (
								'escape' => false,
								'class' => 'btn btn-default',
								'role' => 'button'
						) );
						?>
						</li>
						<li><?php echo $this->Html->link($this->Html->tag ( 'span', '', array (
								'class' => 'glyphicon glyphicon-book'
						) ) . ' ' . '課題管理'
								, array('teacher' => true, 'controller' => 'subjects', 'action' => 'index'), array (
								'escape' => false,
								'class' => 'btn btn-default',
								'role' => 'button'
						) );?>
						</li>

					</ul>
				</div>
			</ul>
		</div>