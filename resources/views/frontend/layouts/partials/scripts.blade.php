<script src="{{ asset('frontend') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="{{ asset('frontend') }}/js/plugins/bootstrap-switch.js"></script>
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="{{ asset('frontend') }}/js/plugins/nouislider.min.js" type="text/javascript"></script>
<script src="{{ asset('frontend') }}/js/plugins/moment.min.js"></script>
<script src="{{ asset('frontend') }}/js/plugins/datetimepicker.js" type="text/javascript"></script>
<script src="{{ asset('frontend') }}/js/plugins/bootstrap-datepicker.min.js"></script>
<!--  Google Maps Plugin    -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<script src="{{ asset('frontend') }}/js/frontend.min.js?v=1.2.0" type="text/javascript"></script>
<script src="https://unpkg.com/feather-icons"></script>
<script>
  $('.page-content').css({ minHeight: window.innerHeight-50 });
  feather.replace()
</script>

<script type="text/javascript" src="{{ asset('admin') }}/vendor/parsleyjs/parsley.min.js"></script>


@if(setting('RECAPTCH_TYPE')=='GOOGLE')
  <script src='https://www.google.com/recaptcha/api.js'></script>
@endif