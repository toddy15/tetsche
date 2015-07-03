@if (Request::is('archiv/*'))
    <script type="text/javascript">
        var button = $("#btn-solution");
        button.on("click", function() {
            if (button.html() == "Lösung anzeigen") {
                button.html("Lösung verstecken");
                $("#solution").removeClass("hidden").addClass("show");
            }
            else {
                button.html("Lösung anzeigen");
                $("#solution").removeClass("show").addClass("hidden");
            }
        });
    </script>
@endif
@if (Request::is('gästebuch/neu'))
    @inject ('utils', 'App\TwsLib\Utils')
    <script type="text/javascript">
        @foreach ($utils->getSmileysIDsAndText() as $code => $filename)
          $("#smiley-{!! $filename !!}").click(function() {
                    $("#message").val($("#message").val() + "{!! $code !!}");
                });
        @endforeach
    </script>
@endif
