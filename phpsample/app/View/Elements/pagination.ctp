<ul class="pagination" style="padding-left: 0px">

	<div>
	<?php
	echo $this->Paginator->counter ( array (
			'format' => __ ( ' {:page} 	ページ / {:pages} ページ,  {:current} 件  / {:count} 件表示, {:start} 件から {:end} 件まで' )
	) );
	?>
	</div>

		<?php
		echo $this->Paginator->prev ( '&laquo;', array (
				'tag' => 'li',
				'escape' => false
		), '<a href="#">&laquo;</a>', array (
				'class' => 'prev disabled',
				'tag' => 'li',
				'escape' => false
		) );
		echo $this->Paginator->numbers ( array (
				'separator' => '',
				'tag' => 'li',
				'currentLink' => true,
				'currentClass' => 'active',
				'currentTag' => 'a'
		) );
		echo $this->Paginator->next ( '&raquo;', array (
				'tag' => 'li',
				'escape' => false
		), '<a href="#">&raquo;</a>', array (
				'class' => 'prev disabled',
				'tag' => 'li',
				'escape' => false
		) );
		?>
	</ul>
