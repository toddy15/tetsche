<div class="mb-4">
    <label class="form-label" for="title">Titel:</label>
    <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" id="title" name="title"
        placeholder="Titel der Ausstellung" autofocus required value="{{ old('title') ?? ($exhibition->title ?? '') }}">
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label class="form-label" for="description">Beschreibung:</label>
    <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" id="description" name="description"
        placeholder="Beschreibung" required rows="30" cols="80">{{ old('description') ?? ($exhibition->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label class="form-label" for="image">Bild:</label>
    <input type="text" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image" name="image"
        placeholder="Bild" required value="{{ old('image') ?? ($exhibition->image ?? '') }}">
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label class="form-label" for="show_until">Bis:</label>
    <input type="text" class="form-control {{ $errors->has('show_until') ? 'is-invalid' : '' }}" id="show_until" name="show_until"
        placeholder="Bild" required value="{{ old('show_until') ?? ($exhibition->show_until ?? '') }}">
    @error('show_until')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
