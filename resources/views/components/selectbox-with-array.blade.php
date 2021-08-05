<div class="form-group {{ $errors->has($name) ? 'has-danger' : '' }}">
  <label for="{{ $name }}">{{ $title }}</label>

  <select class="form-control" id="{{ $name }}" name="{{ $name }}">
    <option> --select-- </option>
    @foreach($objects as $object)
      <option 
        value="{{ $object['id'] }}"
        {{ old($name, $selected) == $object['id'] ? 'selected': '' }}
      >
        {{ $object[$objectName] }}
      </option>
    @endforeach
  </select>

  @if($errors->has($name))
      <label class="error mt-2 text-danger">{{ $errors->first($name) }}</label>
  @endif
</div>