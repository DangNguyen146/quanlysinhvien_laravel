<!-- MDB -->
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="{{ asset('js/mdb.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@yield('libscript')
@yield('customscript')
<script src="{{ asset('js/scripts.js') }}"></script>

<script src="{{ asset('js/wow.min.js') }}"></script>
<script>
    new WOW().init();
</script>


</body>

</html>