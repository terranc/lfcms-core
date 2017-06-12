<form class="form-table {{ $class }}"
      enctype="multipart/form-data"
      method="POST"
      action="{{ $data ? route("$model.update", $data->id) : route("$model.store") }}"
      novalidate
      accept-charset="UTF-8"
      autocomplete="off"
      onsubmit="return false;"
      v-ajax-form>
    @if($data)
        <input type="hidden" name="_method" value="PATCH">
        <input type="hidden" name="id" value="{{ $data->id }}">
        @component('admin.components.form-item', ['label'=>'ID'])
            {{ $data->id }}
        @endcomponent
    @else
        <input type="hidden" name="_method" value="POST">
    @endif
    {{ $slot }}
    {{ csrf_field() }}
    <input type="hidden" name="from_url" value="{{ $_SERVER['HTTP_REFERER'] }}">
</form>
