<?php

namespace App\Http\Requests\Interview;

use App\Models\Interview;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $uuid = $this->route('uuid');

        return [
            'user_id' => ['required', Rule::exists('users', 'id'), Rule::unique('interviews', 'user_id')->ignore($uuid, 'uuid')],            
            'date_time' => ['required', 'date_format:Y-m-d H:i:s'],
            'status' => ['required', Rule::in([
                Interview::STATUS_SCHEDULED,
                Interview::STATUS_SELECTED_FOR_TRAIL,
                Interview::STATUS_SELECTED,
                Interview::STATUS_REJECTED_AFTER_TRAIL,
                Interview::STATUS_REJECTED_IN_INTERVIEW,
            ])],
        ];
    }

    public function attributes(){
        return [
            'user_id' => 'user'
        ];
    }
}
