@if (Request::is('gästebuch/neu') or Request::is('gästebuch/*/edit'))
    @inject ('utils', 'App\TwsLib\Utils')
    <script type="text/javascript">
        @foreach ($utils->getSmileysIDsAndText() as $code => $filename)
          $("#smiley-{!! $filename !!}").click(function() {
                    $("#message").val($("#message").val() + "{!! $code !!}");
                });
        @endforeach
    </script>
@endif
