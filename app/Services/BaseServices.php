<?php

namespace App\Services;

class BaseServices
{
    public function validate($request, $module, $customize = [])
    {
        $rules = [
            'name' => 'required',
            'code' => 'required',
        ];
        $rules = array_merge($rules, $customize);

        $validateMes = [
            'name.required' => 'Vui lòng nhập tên',
            'code.required' => 'Vui lòng nhập code',
            'value.required' => 'Vui lòng nhập giá trị',
        ];

        $request->validate($rules, $validateMes);
    }
}
