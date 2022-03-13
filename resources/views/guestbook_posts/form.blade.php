@inject ('utils', 'App\TwsLib\Utils')

<!-- Name Form Input  -->
<div class="form-group {{ $errors->has('name') ? 'has-error has-feedback' : '' }}">
    <label for="name">Name:</label>
    <input type="text" class="form-control" id="name" placeholder="Ihr Name" autofocus value="{{ old("name") }}">
    @if ($errors->has('name'))
        <span class="glyphicon glyphicon-remove form-control-feedback"></span>
    @endif
</div>

<!-- Message Form Input  -->
<div class="form-group {{ $errors->has('message') ? 'has-error has-feedback' : '' }}">
    <label for="message">Nachricht:</label>
    <textarea class="form-control" id="message" placeholder="Ihre Nachricht">
        {{ old("name") }}
    </textarea>
    @if ($errors->has('message'))
        <span class="glyphicon glyphicon-remove form-control-feedback"></span>
    @endif
</div>

<!-- Images Input  -->
<div class="text-center">
    <ul class="list-inline">
        @foreach ($utils->getSmileysImages() as $image)
            <li>{!! $image !!}</li>
        @endforeach
    </ul>
</div>
