<h5>{{ $text }}</h5>
<input type="text" name="{{ $cName }}" value="{{ old($cName) ?? $object->$name ?? '' }}">
