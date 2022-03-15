@inject ('utils', 'App\TwsLib\Utils')

<!-- Name Form Input  -->
<div class="form-group {{ $errors->has('name') ? 'has-error has-feedback' : '' }}">
    <label for="name">Name:</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Ihr Name" autofocus value="{{ old("name") }}">
</div>

<!-- Message Form Input  -->
<div class="form-group {{ $errors->has('message') ? 'has-error has-feedback' : '' }}">
    <label for="message">Nachricht:</label>
    <textarea class="form-control" id="message" name="message" placeholder="Ihre Nachricht" rows="10" cols="50">{{ old("name") }}</textarea>
</div>

<!-- Images Input  -->
<div class="text-center">
    <ul class="list-inline">
        @foreach ($utils->getSmileysImages() as $image)
            <li>{!! $image !!}</li>
        @endforeach
    </ul>
</div>
