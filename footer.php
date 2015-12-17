	<footer class="text-center">
		<?php echo getStatic("contato_email", "texto"); ?>
	</footer>	

	<script>
		//Update visitors online
		setInterval(function(){
			$.get("<?php echo CP; ?>/model/update.visitors.online", {url : "<?php echo $_SERVER["REQUEST_URI"] ?>", ip : "<?php echo $_SERVER['REMOTE_ADDR']; ?>"});
		}, 5000);

		$(document).ready(function(){
			$(".maskTelefones").mask("(99) 9999-9999?9");
		});
	</script>

	</body>
</html>