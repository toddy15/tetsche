@inject ('utils', 'App\TwsLib\Utils')

<div class="mb-4">
    <label class="form-label" for="name">Name:</label>
    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name"
           placeholder="Ihr Name" autofocus value="{{ old("name") ?? $guestbook_post->name ?? '' }}">
    @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label class="form-label" for="message">Nachricht:</label>
    <textarea class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}" id="message" name="message"
              placeholder="Ihre Nachricht" rows="10"
              cols="50">{{ old("message") ?? $guestbook_post->message ?? '' }}</textarea>
    @error('message')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Images Input  -->
<div class="text-center">
    <ul class="list-inline">
        @foreach ($utils->getSmileysButtons() as $button)
            <li class="list-inline-item">{!! $button !!}</li>
        @endforeach
    </ul>
</div>

<script>
function insert(code) {
   var text = document.getElementById("message");
   text.innerHTML += code;
}
</script>
