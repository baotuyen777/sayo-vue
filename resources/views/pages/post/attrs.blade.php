@foreach($fields as $fieldName)
    @php
        $field = $attrs[$fieldName];
        $type = $field['type'] ?? 'text';

        if (!\View::exists('component.form.'.$type)){
            $type = 'text';
        }
    @endphp
    @include('component.form.'.$type,['name' => $fieldName, 'label' => $field['label'],'options' => $field['options'] ??[]])
@endforeach

