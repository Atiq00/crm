<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title> Touchstone CRM  {{-- {{ $site->title }} | {{ setting('site_title') }} --}}</title>

        <!-- Favicon -->
        <link href="{{ asset('uploads/logo/'.setting('site_favicon')).'?'.time() }}" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Icons -->
        <link href="{{ asset('admin') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('admin') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">

        {{-- <link rel="stylesheet" type="text/css" href="{{ asset('admin') }}/vendor/DataTables/datatables.min.css"/> --}}

        <link  href="{{ asset('admin') }}/vendor/cropperjs/cropper.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('admin') }}/vendor/animate.css/animate.min.css">
        <link rel="stylesheet" href="{{ asset('admin') }}/vendor/sweetalert2/dist/sweetalert2.min.css">

        <!-- Page plugins -->
        <link rel="stylesheet" href="{{ asset('admin') }}/vendor/select2/dist/css/select2.min.css">
        <link rel="stylesheet" href="{{ asset('admin') }}/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css" />
        <link rel="stylesheet" href="{{ asset('admin') }}/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" />
        <link rel="stylesheet" href="{{ asset('admin') }}/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css" />
        <link rel="stylesheet" href="{{ asset('admin') }}/vendor/pickr/themes/nano.min.css"/> <!-- 'nano' theme -->



        <!-- ADMIN CSS -->
        <link type="text/css" href="{{ asset('admin') }}/css/admin.min.css?v=1.0.0" rel="stylesheet">

        <style>
          input{
     color: black;
}

            .select2-container--default .select2-results__option[aria-selected='true']{
              font-weight: 600;
            }

            .ticket-replies::-webkit-scrollbar {
              background: #f7fafc;
              height: 6px;
              width: 6px;
            }
            .ticket-replies::-webkit-scrollbar:disabled {
              background: transparent;
            }

            .ticket-replies::-webkit-scrollbar-track {
              height: 10px;
              width: 10px;
            }

            .ticket-replies::-webkit-scrollbar-thumb {
              background: rgba(24, 188, 155, 0.6);
              border-radius: 10px;
            }
            .ticket-replies::-webkit-scrollbar-thumb:hover {
              background: rgba(24, 188, 155, 0.75);
            }
            .ticket-replies::-webkit-scrollbar-thumb:active {
              background: rgba(24, 188, 155, 0.9);
            }

            .ticket-replies::-webkit-scrollbar-thumb:window-inactive {
              background: rgba(24, 188, 155, 0.2);
            }

            .ticket-replies{
              overflow-y: auto;
              max-height: 50rem;
            }

            .select2-container--default .select2-selection--multiple .select2-selection__choice{
                  color: var(--theme-color);
                  background-color: var(--theme-color-light);
            }
            .card-footer {
    background-color: #fff;
    border-top: 1px solid rgba(0, 0, 0, 0.125);
}



        </style>

        <script src="{{ asset('admin') }}/vendor/jquery/dist/jquery.min.js"></script>
      <script src="{{ asset('admin') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @include('admin.layouts.navbars.sidebar')
        @endauth

        <div class="main-content" id="panel">
            @include('admin.layouts.navbars.navbar')
            @yield('content')
        </div>

        @guest()
            @include('admin.layouts.footers.guest')
        @endguest


        <!-- Core -->

      <script src="{{ asset('admin') }}/vendor/js-cookie/js.cookie.js"></script>
      <script src="{{ asset('admin') }}/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
      <script src="{{ asset('admin') }}/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
      <script src="https://unpkg.com/feather-icons"></script>
      <script>
          feather.replace()
      </script>
      <script type="text/javascript" src="{{ asset('admin') }}/vendor/parsleyjs/parsley.min.js"></script>

        <!-- Optional JS -->
      <script src="{{ asset('admin') }}/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
      <script src="{{ asset('admin') }}/vendor/bootstrap-notify/bootstrap-notify.min.js"></script>

      <!-- DataTables -->
      <script src="{{ asset('admin') }}/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
      <script src="{{ asset('admin') }}/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
      <script>

            /* Set the defaults for DataTables initialisation */
            $.extend( $.fn.dataTable.defaults, {
                keys: !0,
                language: {
                  paginate: {
                    previous: "<i class='fas fa-angle-left'>",
                    next: "<i class='fas fa-angle-right'>"
                  }
                },
              });


    // Init the datatable

       $(document).on( 'init.dt', function () {
        $('div.dataTables_length select').removeClass('custom-select custom-select-sm');
      });

        @if ($message = Session::get('success'))

          $.notify({
            // options
            message: '{{ $message }}',
            icon: 'ni ni-check-bold',
          },{
            // settings
            type: 'success',
            offset: 50,
          });

          @endif


          @if ($message = Session::get('error'))

          $.notify({
            // options
            message: '{{ $message }}',
            icon: 'ni ni-fat-remove',
          },{
            // settings
            type: 'danger',
            offset: 50,
          });

          @endif


          @if ($message = Session::get('warning'))

          $.notify({
            // options
            message: '{{ $message }}',
            icon: 'ni ni-bell-55',
          },{
            // settings
            type: 'warning',
            offset: 50,
          });

          @endif


          @if ($message = Session::get('info'))

          $.notify({
            // options
            message: '{{ $message }}',
            icon: 'ni ni-bell-55',
          },{
            // settings
            type: 'danger',
            offset: 50,
          });

          @endif


          @if ($errors->any())

          $.notify({
            // options
            message: '{{ $message }}',
            icon: 'ni ni-bell-55',
          },{
            // settings
            type: 'danger',
            offset: 50,
          });

          @endif

          if ( document.getElementById('my-form') ) {
            $("#my-form").parsley({
               errorClass: 'is-invalid text-danger',
               successClass: 'is-valid',
               errorsWrapper: '<span class="form-text text-danger"></span>',
               errorTemplate: '<span></span>',
               trigger: 'change'
             });
          }


        </script>
      <script src="{{ asset('admin') }}/vendor/datatables.net-select/js/dataTables.select.min.js"></script>
      <script src="{{ asset('admin') }}/vendor/select2/dist/js/select2.min.js"></script>
      <script src="{{ asset('admin') }}/vendor/pickr/pickr.min.js"></script>


      <script>if(document.getElementsByClassName('select2-select')){

        $('.select2-select').select2({
            minimumResultsForSearch: -1
        })
      }

      // Simple example, see optional options for more configuration.
      window.setColorPicker = (elem, defaultValue) => {

        elem = document.querySelector(elem);

        let pickr = Pickr.create({
            el: elem,
            default: defaultValue,
            theme: 'nano', // or 'monolith', or 'nano'
            useAsButton: true,

            swatches: [
                '#217ff3',
                '#11cdef',
                '#fb6340',
                '#f5365c',
                '#f7fafc',
                '#212529',
                '#2dce89'
            ],

            components: {

                // Main components
                preview: true,
                opacity: true,
                hue: true,

                // Input / output Options
                interaction: {
                    hex: true,
                    rgba: true,
                    // hsla: true,
                    // hsva: true,
                    // cmyk: true,
                    input: true,
                    clear: true,
                    silent: true,
                    preview: true,
                }
            }
        });

        pickr.on('init', pickr => {
          elem.value = pickr.getSelectedColor().toRGBA().toString(0);
        }).on('change', color => {
          elem.value = color.toRGBA().toString(0);
          // pickr.hide();
        });


        return pickr;

      }

      function preview_image(event, ID)
            {
              if(ID==undefined){
                ID = 'preview-image';
              }

                 var reader = new FileReader();
                 reader.onload = function()
                 {
                      var output = document.getElementById(ID);
                      output.src = reader.result;
                 }
                 reader.readAsDataURL(event.target.files[0]);
            }


      </script>

      @stack('js')

      <!-- ADMIN JS -->
      <script src="{{ asset('admin') }}/js/admin.js?v=1.1.0"></script>
    </body>
</html>
