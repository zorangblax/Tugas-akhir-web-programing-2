<!-- Footer -->
<footer class="sticky-footer bg-white">
	<div class="container my-auto">
		<div class="copyright text-center my-auto">
			<span>Copyright &copy; News </span>
		</div>
	</div>
</footer>

<!-- End of Footer -->



<script src="<?= base_url() ?>template/front-end/js/jquery-3.2.1.min.js"></script>
<script src="<?= base_url() ?>template/front-end/styles/bootstrap4/popper.js"></script>
<script src="<?= base_url() ?>template/front-end/styles/bootstrap4/bootstrap.min.js"></script>
<script src="<?= base_url() ?>template/front-end/plugins/greensock/TweenMax.min.js"></script>
<script src="<?= base_url() ?>template/front-end/plugins/greensock/TimelineMax.min.js"></script>
<script src="<?= base_url() ?>template/front-end/plugins/scrollmagic/ScrollMagic.min.js"></script>
<script src="<?= base_url() ?>template/front-end/plugins/greensock/animation.gsap.min.js"></script>
<script src="<?= base_url() ?>template/front-end/plugins/greensock/ScrollToPlugin.min.js"></script>
<script src="<?= base_url() ?>template/front-end/plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="<?= base_url() ?>template/front-end/plugins/easing/easing.js"></script>
<script src="<?= base_url() ?>template/front-end/plugins/parallax-js-master/parallax.min.js"></script>
<script src="<?= base_url() ?>template/front-end/js/custom.js"></script>



<script>
	ClassicEditor
		.create(document.querySelector('#body'), {
			toolbar: {
				items: ['heading', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote', 'link']
			}
		})
		.catch(error => {
			console.log(error);
		});
</script>

<script>
	document.getElementById('myForm').addEventListener('submit', function(event) {
		event.preventDefault(); // Mencegah pengiriman formulir secara langsung

		// Ambil nilai dari select dan input
		var selectValue = document.getElementById('kategorijava').value;
		var inputValue = document.getElementById('keyword').value;

		// Gabungkan nilai select dengan nilai input (misalnya dengan tanda hubung '-')
		var combinedValue = selectValue + ' ' + inputValue;

		// Setel nilai input dengan nilai gabungan
		document.getElementById('keyword').value = combinedValue;

		// Sekarang formulir siap untuk dikirim dengan nilai yang digabungkan
		this.submit(); // Submit formulir
	});
</script>
</body>

</html>