<link rel="shortcut icon" href="/images/favicon.svg" type="image/x-icon" />
<link rel="icon" sizes="any" href="/images/favicon.svg" type="image/svg+xml">
<link rel="mask-icon" href="/images/favicon.svg" color="black">
@yield('stylesheet')
@yield('javascript')
<script>
  $(function($) {
    $.i18n().load({
      'en': '/translations/en.json',
      'ja': '/translations/ja.json'
    }).done( function() { console.log('translation loaded'); } );
    var changeLocale = function (locale) {
      $.ajax({
        url: '/helpers/change-locale',
        data: {locale: locale},
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'POST',
        success: function () {
          location.reload();
        }
      });
    }
    var changeRowPerPage = function (rpp) {
      $.ajax({
        url: '/helpers/change-row-per-page',
        data: {rpp: rpp},
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'POST',
        success: function () {
          location.reload();
        }
      });
    }

    $('.grids-control-records-per-page').change(function() {
      var rpp = $(this).val();
      changeRowPerPage(rpp);

    })

    $('.navbar-change-locale').change(function() {
      var locale = $(this).val();
      changeLocale(locale);
    });

    $(document).ajaxStart(function() {
      $(".overlay").addClass('active');
    });

    $(document).ajaxStop(function() {
      $(".overlay").removeClass('active');
    });
  });
</script>
