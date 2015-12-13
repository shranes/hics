<!-- file: /app/View/Elements/header.ctp -->
<?php //echo $this->element('header');?>

<!-- jQueryを全ページで読み込み -->
<?php echo $this->Html->script('jquery-1.11.3.min.js')?>

<?php //参考 http://codezine.jp/article/detail/8182?>

<?php echo $this->Html->css('header.css');?>


<!-- 1.ナビゲーションバーの設定 -->

<!-- ヘッダー部 -->
<header class="jumbotron">
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<!-- 2.ヘッダ情報 -->


			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed"
					data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
					aria-expanded="false">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>

      <?php
						$ToppageStr = 'HICS';
						if (! empty ( $user )) {
							// ユーザ情報へのリンク
							if ($user ['Group'] ['name'] === 'students') {
								echo $this->Html->link ( $ToppageStr, array (
										'teacher' => false,
										'controller' => 'posts',
										'action' => 'index'
								), array (
										'class' => 'navbar-brand'
								) );
								// echo 'Students';
							} else if ($user ['Group'] ['name'] === 'teachers') {
								echo $this->Html->link ( $ToppageStr, array (
										'teacher' => true,
										'controller' => 'posts',
										'action' => 'teacher_index'
								), array (
										'class' => 'navbar-brand',

								) );
								// echo 'Teachers';
							} else if ($user ['Group'] ['name'] === 'administrators') {
								echo $this->Html->link ( $ToppageStr, array (
										'teacher' => true,
										'controller' => 'posts',
										'action' => 'teacher_index'
								), array (
										'class' => 'navbar-brand'
								) );
								// echo 'Admin';
							} else {
								echo $this->Html->link ( $ToppageStr, array (
										'teacher' => true,

										'controller' => 'posts',
										'action' => 'index'
								), array (
										'class' => 'navbar-brand'
								) );
							}
						} else {
							echo $this->Html->link ( $ToppageStr, array (
									'teacher' => false,
									'controller' => 'posts',
									'action' => 'index'
							), array (
									'class' => 'navbar-brand'
							) );
						}
						?>
    </div>



			<div class="collapse navbar-collapse"
				id="bs-example-navbar-collapse-1">
				<!-- 3.リストの配置 -->
				<ul class="nav navbar-nav">
					<li><a>
				<?php
				if (AuthComponent::user ( 'userlname' ) === null) {
					echo 'ゲスト';
				} else {
					echo AuthComponent::user ( 'userlname' );
				}
				?>さん、こんにちは。
				</a></li>
					<li>
				<?php
				if (! empty ( $user )) {
					// ユーザ情報へのリンク
					if ($user ['Group'] ['name'] === 'students') {
						echo $this->Html->link ( 'ユーザ情報', array (
								'teacher' => false,
								'controller' => 'users',
								'action' => 'view'
						) );
					} else if ($user ['Group'] ['name'] === 'teachers') {
						echo $this->Html->link ( 'ユーザ情報', array (
								'teacher' => true,
								'controller' => 'users',
								'action' => 'teacher_view'
						) );
					} else if ($user ['Group'] ['name'] === 'administrators') {
						echo $this->Html->link ( 'ユーザ情報', array (
								'teacher' => true,
								'controller' => 'users',
								'action' => 'teacher_view'
						) );
					}
					echo nl2br ( '</li><li>' );
					echo $this->Html->link ( 'ログアウト', array (
							'teacher' => false,
							'controller' => 'users',
							'action' => 'logout'
					) );
				} else {
					echo $this->Html->link ( 'ログイン', array (
							'teacher' => false,
							'controller' => 'users',
							'action' => 'login'
					) );
				}
				?>
			</li>
				</ul>
			</div>
		</div>
	</nav>
</header>
