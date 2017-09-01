$(document).ready(function(){
	$(function(){
		$('#tags').tagEditor({
			initialTags: [],
			delimiter: ', ', /* space and comma */
			placeholder: ''
		});
	});
});
