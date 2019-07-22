<script src="//code.jquery.com/jquery-3.4.1.min.js"></script>

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

		$('.hide-if-no-js').removeClass('hide-if-no-js');
		$('.hide-if-js').hide();
		
		$('#customise-toggle').on('click', function (event) {
			$('#customise-link').slideToggle('show');
		});
	});
</script>