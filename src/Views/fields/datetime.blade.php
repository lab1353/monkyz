<div class="form-group">
	<label for="{{ $field }}">@if(!empty($params['title'])){{ $params['title'] }}@else{{ $field }}@endif @if(in_array('required', array_keys($params['attributes']))) <strong>*</strong>@endif</label>
	<input type="datetime-local" class="form-control @if(!empty($params['attributes']['class'])){{ $params['attributes']['class'] }}@endif"
		id="{{ $field }}" name="{{ $field }}"
		placeholder="{{ $params['title'] }}" value="{{ substr($record->$field->toRfc3339String(), 0 ,19) }}"
		step="1"
		@if(!empty($params['attributes']))
			@foreach($params['attributes'] as $k=>$v)
				@if(!empty($k))
					{{ $k }}="{{ $v }}"
				@endif
			@endforeach
		@endif
	>
</div>