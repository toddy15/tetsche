@inject ('utils', 'App\TwsLib\Utils')

<!-- Name Form Input  -->
<div class="form-group {{ $errors->has('name') ? 'has-error has-feedback' : '' }}">
    {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ihr Name', 'autofocus']) !!}
    @if ($errors->has('name'))
        <span class="glyphicon glyphicon-remove form-control-feedback"></span>
    @endif
</div>

<!-- Message Form Input  -->
<div class="form-group {{ $errors->has('message') ? 'has-error has-feedback' : '' }}">
    {!! Form::label('message', 'Nachricht:', ['class' => 'control-label']) !!}
    {!! Form::textarea('message', null, ['class' => 'form-control', 'placeholder' => 'Ihre Nachricht']) !!}
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
