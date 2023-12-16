@foreach($fields as $fieldName)
    @php
        $field = $attrs[$fieldName];
        $type = $field['type'] ?? 'text'
    @endphp
    @include('component.form.select',['name' => $fieldName, 'label' => $field['label'],'options' => $field['options'] ??[]])
@endforeach

