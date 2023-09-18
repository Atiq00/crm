<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('frontend') }}/img/apple-icon.png">
<link rel="icon" type="image/png" href="{{ asset('uploads/logo/'.setting('frontend_favicon')).'?'.time() }}">
<title>
 	{{ setting('site_title') }}
</title>
<meta name="description" content="{{ setting('site_description') }}">

<style>
:root {
  --blue: #5e72e4;
  --indigo: #5603ad;
  --purple: #8965e0;
  --pink: #f3a4b5;
  --red: #f5365c;
  --orange: #fb6340;
  --yellow: #ffd600;
  --green: #2dce89;
  --teal: #11cdef;
  --cyan: #2bffc6;
  --white: #fff;
  --gray: #8898aa;
  --gray-dark: <?php echo setting('theme_color') ?>;
  --light: #ced4da;
  --lighter: #e9ecef;
  --primary: <?php echo setting('theme_color') ?>;
  --primary-dark: <?php echo setting('theme_color_dark') ?>;
  --secondary: #f4f5f7;
  --success: #2dce89;
  --info: #11cdef;
  --warning: #fb6340;
  --danger: #f5365c;
  --light: #adb5bd;
  --dark: #212529;
  --default: #172b4d;
  --white: #fff;
  --neutral: #fff;
  --darker: black;
  --breakpoint-xs: 0;
  --breakpoint-sm: 576px;
  --breakpoint-md: 768px;
  --breakpoint-lg: 992px;
  --breakpoint-xl: 1200px;
  --font-family-sans-serif: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
  --font-family-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
  
 	/* App Variables */
  --theme: <?php echo setting('theme_color') ?>;
  --theme-text: #117aef;
  
  --white: #fff;
  --dark: #24272D;
  --darker: black;
  --font-family-main: 'Montserrat', sans-serif;
  --font-family-secondary: 'Open Sans', sans-serif;
}


</style>

<!--     Fonts and icons     -->
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;700&family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet" />
<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
<!-- Nucleo Icons -->
<link href="{{ asset('frontend') }}/css/nucleo-icons.css" rel="stylesheet" />
<link href="{{ asset('frontend') }}/css/nucleo-svg.css" rel="stylesheet" />
<!-- Font Awesome Icons -->
<link href="{{ asset('frontend') }}/css/font-awesome.css" rel="stylesheet" />
<link href="{{ asset('frontend') }}/css/nucleo-svg.css" rel="stylesheet" />
<!-- CSS Files -->
<link href="{{ asset('frontend') }}/css/frontend.css?v=<?php echo time(); ?>" rel="stylesheet" />
<link href="{{ asset('frontend') }}/css/ckeditor-styles.css?v=<?php echo time(); ?>" rel="stylesheet" />
<link href="{{ asset('frontend') }}/css/app.css?v=<?php echo time(); ?>" rel="stylesheet" />

<!--   Core JS Files   -->
<script src="{{ asset('frontend') }}/js/core/jquery.min.js" type="text/javascript"></script>
<script src="{{ asset('frontend') }}/js/core/popper.min.js" type="text/javascript"></script>
<script src="{{ asset('frontend') }}/js/core/bootstrap.min.js" type="text/javascript"></script>

<script async charset="utf-8" src="//cdn.embedly.com/widgets/platform.js"></script>
