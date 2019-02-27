@extends('app')

@section('content')
    <h1 style="color:#fdb3b4;font-size:81px;margin-bottom:80px;">Tetsche-Website</h1>
    <div class="row">
        <div class="col-sm-6">
            <img class="center-block img-responsive" src="{{ asset('images/agathenburg.jpg') }}" style="margin-bottom:80px;"
              alt="Ausstellung Schloss Agathenburg" title="Ausstellung Schloss Agathenburg" width="624" height="879" />
        </div>
        <div class="col-sm-6">
            <h2 style="color:#fdb3b4">Tetsche&nbsp;&ndash; Cartoons und andere Kostbarkeiten</h2>
            @if(date("Y-m-d") <= "2019-03-02")
            <p>
              Am Samstag, den 2. März um 17 Uhr
              sind Sie und Ihre Freunde herzlich
              zur Ausstellungseröffnung eingeladen.
            </p>
            <p>
              Mit Beiträgen von<br />
              Michael Roesberg, Stiftungsratsvorsitzender und Landrat<br />
              Piet Klocke, Kabarettist, Musiker, Autor und Schauspieler<br />
            </p>
            @endif
            <p>
              Vom 3. März bis 28. April 2019<br />
              Dienstag bis Freitag: 14&nbsp;&ndash; 18 Uhr<br />
              Samstag und Sonntag: 11&nbsp;&ndash; 18 Uhr<br />
              Gruppen zusätzlich nach Vereinbarung
            </p>
            <p>
              Kulturstiftung Schloss Agathenburg<br />
              Hauptstraße, 21684 Agathenburg (bei Stade)<br />
            </p>
            <p>
              <a href="https://www.schlossagathenburg.de/" class="btn btn-danger">Website Schloss Agathenburg</a>
            </p>
        </div>
    </div>
@stop
