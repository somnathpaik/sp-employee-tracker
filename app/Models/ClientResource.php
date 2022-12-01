<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientResource extends Model
{
    use HasFactory;
    protected $fillable = [

        'client_id',
        'working_user_id',
        'hire_user_id',
        'month',
        'year',
        'start_date',
        'end_date',
        'hours',
        'status',
        'service_id',
        'hire_resource_status',
        'work_type'
    ];

    CONST STATUS_ACTIVE = 'Active';
    CONST STATUS_COMPLETED = 'Completed';
    CONST STATUS_IN_ACTIVE = 'In-active';

    public function working_resource()
    {
        return $this->belongsTo(User::class, 'working_user_id', 'id')->with(['client_status_value', 'work_status_value'])->withTrashed();
    }
    public function hire_resource()
    {
        return $this->belongsTo(User::class, 'hire_user_id', 'id')->with(['client_status_value', 'work_status_value'])->withTrashed();
    }


    public function client_details()
    {
        return $this->belongsTo(Clients::class, 'client_id', 'id');
    }

    public function resource_status()
    {
        return $this->belongsTo('App\Models\ClientStatus', 'hire_resource_status');
    }

    public function workType()
    {
        return $this->belongsTo('App\Models\WorkType', 'work_type');
    }

}
