		    <div class="footer-panel">
		    	<p class="text-left">Copyright 2016 PlatoLMS.
		    		<a href="#">Documentation.</a>
		    		<a href="#">Plugins.</a>
		    		<a href="#">Integration.</a>
		    		<a href="#">Themes.</a>
		    	</p>
		    </div>

		</div>

        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ elixir('js/all.js') }}"></script>

    @yield('scripts')

@if (isset($overlay)) 
	<div class="modal-backdrop fade in">
@endif

</body>
</html>
