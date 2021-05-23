<form method="POST" action="/shorten">
    @csrf

    <div class="form-group row">
        <label for="url" class="col-md-1 col-form-label text-md-right">{{ __('URL') }}</label>

        <div class="col-md-8">
            <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ old('url') }}" required autofocus>

            @error('url')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-md-1 form-check">
            <input type="checkbox" class="form-check-input" id="nsfw">
            <label class="form-check-label" for="nsfw">NSFW</label>
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Shorten URL!</button>
        </div>
    </div>
</form>