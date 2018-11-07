<script src="//code.jquery.com/jquery-3.3.1.slim.min.js"></script>

<script>
	$(document).ready(function() {
		$('.link').click(function() {
			event.preventDefault();
			newLocation = this.href;
			$('body').fadeOut(1000, newpage);
		});

		function newpage() {
			window.location = newLocation;
		}

		$( "#close" ).click(function() {
			$( "#error" ).fadeOut("slow");
		});
	});
</script>