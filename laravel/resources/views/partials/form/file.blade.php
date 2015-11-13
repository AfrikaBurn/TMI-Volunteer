<div class="form-group {{ ($errors->has($name)) ? 'has-error' : '' }}">
    <label class="control-label" for="{{ $name }}-field">{{ $label }}</label>

    <div>
        <span class="btn btn-primary btn-file">
            <input type="file" name="{{ $name }}" id="{{ $name }}-field">
        </span>
    </div>

    @if($errors->has($name))
        <span class="help-block">{{ $errors->first($name) }}</span>
    @endif
</div>
