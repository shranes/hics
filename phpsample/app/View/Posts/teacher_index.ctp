<!-- File: /app/View/Posts/index.ctp	-->


<?php
// ヘッダー表示
echo $this->element ( 'header' );
?>
<!-- テンプレート -->
<div class="container-fluid">
	<?php echo $this->element('teacher_sidenav');?>
	<!-- メインコンテンツここから -->
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10">
		<!-- テンプレートおわり -->
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-body">新着情報</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-body">
					課題情報
					<div>
						<table
							class="table table-striped table-bordered table-hover table-condensed">
							<thead>
								<tr>
									<th>課題名</th>
									<th>学生</th>
								</tr>
								<?php foreach ($n_reports as $n_report):?>
								<tr class="info">
									<td><?php echo h($n_report['Report']['id']); ?>&nbsp;</td>
									<td><?php echo h($n_report['Report']['Assignment']['title'])?>

									<td><?php
									echo $this->Html->link ( $n_report ['Report'] ['User']['userlname'].' '.$n_report ['Report'] ['User']['userfname'], array (
						'controller' => 'reports',
						'action' => 'view',
						$n_report ['Report'] ['id']
							) );
							?>
									</td>

									<td><?php echo $n_report['Report']['modified'];?>
									</td>
								</tr>
								<?php endforeach;?>
								<?php unset($n_reports);?>

						</table>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
