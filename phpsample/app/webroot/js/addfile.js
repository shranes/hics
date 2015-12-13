

<script>
// なんとしても動的にフォームを追加する（無理くり作成）
$(document).ready(function(){
	var $num = 0;

	// 仕方ないので０個目の削除ボタンを生成
	$('div.input.file').append('<button type="button" id="clear" value="File0Attachment">削除</button>');
	$('#addfile').click(function() {
		$num++;
		if ($num <= 4) {
			$('div.input.file').append('<input type="file" name="data[File][' + $num + '][attachment]" multiple="multiple" id="File' + $num + 'Attachment">');
			$('div.input.file').append('<button type="button" id = "clear" value="File' + $num + 'Attachment">削除</button>');
			$('div.input.file').after( '<input type="hidden" name="data[File][' + $num + '][model]" value="Report" multiple="multiple" id="File' +$num+ 'Model">'
					+ '<input type="hidden" name="data[File][' +$num+ '][user_id]" value="<?php echo AuthComponent::user('id');?>" multiple="multiple" id="File' +$num+ 'UserId">');
			console.log('addfile');
		} else {
			alert('ファイル添付は5個以内');
		}

	});
	$(document).on('click', '#clear',function() {
		$target = '#' + $(this).val();
		console.log($target);
		$($target).val('');
	});
});
</script>