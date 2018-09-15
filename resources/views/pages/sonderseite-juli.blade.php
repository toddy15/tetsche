@extends('app')

@section('content')
    <h1 style="color:#fdb3b4;font-size:81px;margin-bottom:80px;">Tetsche-Website</h1>

    <div class="row">
        <div class="col-md-6" style="margin-bottom: 30px; text-align: center;">
            <a href="https://www.soltau.de/desktopdefault.aspx/tabid-560/1428_read-31093/">
            <img class="center-block img-responsive" src="{{ asset('images/soltau.jpg') }}"
                 alt="Tetsche-Ausstellung in Soltau" title="Tetsche-Ausstellung in Soltau" width="596" height="842" />
            </a>
            <h2 style="color:#fdb3b4">Tetsche &ndash; Cartoons</h2>
            <p>
                Im Museum Soltau<br />
                Dienstag, 19.&nbsp;Juni&nbsp;2018 bis Sonntag, 16.&nbsp;September&nbsp;2018<br />
                Niveauvoller Blödsinn und andere Kostbarkeiten
                vom Meister aus Soltau sind immer von 14 bis 17&nbsp;Uhr
                bei uns für 3&nbsp;€ Eintritt (Kinder frei)
                zu bewundern.<br />
                Heimatbund Soltau<br />
                Poststrasse&nbsp;11, 29614&nbsp;Soltau<br />
                Montags geschlossen
            </p>
            <p>
                <a href="https://www.soltau.de/desktopdefault.aspx/tabid-560/1428_read-31093/" class="btn btn-danger">Museum Soltau</a>
            </p>
        </div>
        <div class="col-md-6" style="margin-bottom: 30px; text-align: center;">
            <a href="https://www.carlsen.de/hardcover/cartoons-und-andere-kostbarkeiten/96575">
            <img class="center-block img-responsive" src="{{ asset('images/gesundheit.jpg') }}"
                 alt="Tetsche &ndash; Cartoons und andere Kostbarkeiten" title="Tetsche &ndash; Cartoons und andere Kostbarkeiten" width="596" height="842" />
            </a>
            <h2 style="color:#fdb3b4">Endlich!</h2>
            <h2 style="color:#fdb3b4">Cartoons &amp; andere Kostbarkeiten</h2>
            <p>
                Das neue, große dicke Tetsche-Buch ist da!<br />
                Live und in Farbe, 208&nbsp;fette Seiten
            </p>
            <p>
                Lappan Verlag<br />
                ISBN 978-3-8303-3516-0
            </p>
            <p>
                <a href="https://www.carlsen.de/hardcover/cartoons-und-andere-kostbarkeiten/96575" class="btn btn-danger">Lappan-Verlag</a>
            </p>
        </div>
    </div>

@stop
