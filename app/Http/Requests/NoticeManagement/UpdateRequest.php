<?php

namespace App\Http\Requests\NoticeManagement;

use App\Models\NoticeManagement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
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
            'user_id' => ['required', Rule::exists('users', 'id'), Rule::unique('notice_management', 'user_id')->ignore($uuid, 'uuid')],
            'notice_type' => ['required', Rule::in(
                [
                    NoticeManagement::NOTICE_TYPE_CLIENT,
                    NoticeManagement::NOTICE_TYPE_INTERNAL
                ]
            )],
            'notice_level' => ['required', Rule::in([
                NoticeManagement::NOTICE_LEVEL_SOFT,
                NoticeManagement::NOTICE_LEVEL_HARD,
                NoticeManagement::NOTICE_LEVEL_NOT_MANAGEABLE
            ])],
            'reason_of_notice' => ['nullable'],
        ];
    }

    public function attributes(){
        return [
            'user_id' => 'user'
        ];
    }
}
