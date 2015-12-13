<!-- file: /app/View/Posts/view.ctp -->



<?php echo $this->element ('header')?>

<!-- テンプレート -->
<div class="container-fluid">
	<?php echo $this->element('teache_sidenav');?>
	<!-- メインコンテンツここから -->
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10">
		<!-- テンプレートおわり -->
		<div class="container-fluid">
		<div class="panel panel-default">
				<div class="panel-body">

			<h1>タイトル：<?php  echo h($post['Post']['title'])?></h1>
			<p>投稿者：<?php echo $post['User']['username']?></p>
			<div
				style="border-width: 1px; border-style: solid; border-color: green;">
				<p><?php echo h($post['Post']['body']);?> </p>
			</div>
			<p>
投稿日: <?php echo $post['Post']['created']?><br>
更新日: <?php echo $post['Post']['modified']?>
</p>

<?php // foreach($?s as $?) : endforeach;?>
<!-- なるほど、ポストのコメントをコメントとして定義するってことね -->
<?php foreach ($post['Comment'] as $comment):?>
<p>
				コメント内容<br>
<?php echo nl2br($comment['comment']);?></p>
			<p>投稿日:<?php echo $comment['created'];?>
<?php endforeach;?>





			<p>ダウンロードリンク</p>
			<p>
<?php
$i = 0;
foreach ( $post ['File'] as $file ) :

	// 画像を表示するよ
	echo $this->Html->image ( '../files' . '/posts/' . $post ['File'] [$i] ['dir'] . '/' . $post ['File'] [$i] ['attachment'] );
	// echo WWW_ROOT.'files'.DS.'posts'.DS.$post['File'][$i]['dir'].DS.$post['File'][$i]['attachment'];
	echo $this->Html->link ( $post ['File'] [$i] ['attachment'], array (
			'controller' => 'Files',
			'action' => 'download',
			$post ['File'] [$i] ['id']
	) );
	// 削除ボタン
	$i ++;
endforeach
;
?>
</p>

<?php
// コメントコントローラのaddアクションへ向けたフォームの作成
echo $this->Form->create ( 'Comment', array (
		'action' => 'add'
) );
echo $this->Form->input ( 'comment', array (
		'rows' => '3'
) );
echo $this->Form->input ( 'Comment.post_id', array (
		'type' => 'hidden',
		'value' => $post ['Post'] ['id']
) );
echo $this->Form->input ( 'Comment.user_id', array (
		'type' => 'hidden',
		'value' => AuthComponent::user ( 'id' )
) );
echo $this->Form->end ( 'コメント投稿' );
?>

<p><?php echo $this->Html->link('一覧へ戻る',array('action'=>'lists', $post['Post']['topic_id']));?>


</p>

		</div>
	</div>
	</div>
	</div>
</div>