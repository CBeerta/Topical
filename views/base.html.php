<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>Topical</title>
  <meta name="description" content="Topical">
  <meta name="author" content="Claus Beerta">

  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="public/favicon.png">
  <!--link rel="apple-touch-icon" href="/apple-touch-icon.png"-->

  <!-- CSS: implied media="all" -->
  <link rel="stylesheet" href="public/css/style.css?v=2">
  <link rel="stylesheet" href="public/css/awesome-buttons.css">
  <link rel="stylesheet" href="public/css/pepper-grinder/jquery-ui-1.8.13.custom.css">

  <!-- Uncomment if you are specifically targeting less enabled mobile browsers
  <link rel="stylesheet" media="handheld" href="css/handheld.css?v=2">  -->

  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  <script src="public/js/libs/modernizr-1.7.min.js"></script>

</head>

<body>

  <div id="container">
    <header>
    </header>
    <div id="main" role="main">
        <?php echo $content; ?>
    </div>
    <footer>
        &copy; 2011 - Today Claus Beerta &lt;<a href="mailto:claus@beerta.de">claus@beerta.de</a>&gt;
    </footer>
  </div> <!--! end of #container -->

  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.js"></script>
  <script>window.jQuery || document.write("<script src='public/js/libs/jquery-1.5.1.min.js'>\x3C/script>")</script>
  <script src="public/js/jquery-ui-1.8.13.custom.min.js"></script>
  <script src="public/js/jquery.jeditable.js"></script>
  <script src="public/js/jquery.jeditable.autogrow.js"></script>
  <script src="public/js/jquery.autogrow.js"></script>

  <!-- scripts concatenated and minified via ant build script-->
  <script src="public/js/plugins.js"></script>
  <script src="public/js/script.js"></script>
  <!-- end scripts-->

</body>
</html>
