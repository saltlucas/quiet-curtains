<!doctype html>
<html @php(language_attributes())>
  @include('partials.head')
  <body @php(body_class())>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TDGM95K"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->    
    @php(do_action('get_header'))
    @include('partials.header')
    <div class="content off-canvas-content" role="document" >
      <main class="main">
        @yield('content')
      </main>
    </div>
    @php(do_action('get_footer'))
    @include('partials.footer')
    @php(wp_footer())
  </body>
</html>
