jQuery(function(){
	jQuery(document).bind("dragover drop", function(e) {
    e.preventDefault();
		}).bind("drop", function(e) {
			jQuery("input[type='file']")
				.prop("files", e.originalEvent.dataTransfer.files);
				console.log(jQuery("input[type='file']").prop('files')[0]);
		});
});