<div class="form-group">
    <label class="col-form-label {{ $class }}">{{ $label }}</label>
    <div class="col-form-control">
        {{ $slot }}
        <div class="help-block">
            <ul class="list-unstyled">
            </ul>
        </div>
    </div>
</div>
