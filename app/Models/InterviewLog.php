<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InterviewLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'interview_id',
        'admin_user_id',
        'employee_user_id',
        'date_time',
        'status',
    ];

    public CONST STATUS_SCHEDULED = 1;
    public CONST STATUS_SELECTED_FOR_TRAIL = 2;
    public CONST STATUS_SELECTED = 3;
    public CONST STATUS_REJECTED_AFTER_TRAIL = 4;
    public CONST STATUS_REJECTED_IN_INTERVIEW = 5;

    public CONST STATUS_ARRAY = [
        self::STATUS_SCHEDULED => 'Scheduled',
        self::STATUS_SELECTED_FOR_TRAIL => 'Selected for Trail',
        self::STATUS_SELECTED => 'Selected',
        self::STATUS_REJECTED_AFTER_TRAIL => 'Rejected after trail',
        self::STATUS_REJECTED_IN_INTERVIEW => 'Rejected in interview',
    ];

    protected $cast = [
        'date_time' => 'datetime',
        'status' => 'integer',
    ];

    protected $appends = [
        'status_text'
    ];

    public function interview() :BelongsTo{
        return $this->belongsTo(Interview::class);
    }

    public function adminUser() :BelongsTo{
        return $this->belongsTo(User::class, 'admin_user_id')->withTrashed();
    }

    public function employeeUser() :BelongsTo{
        return $this->belongsTo(User::class, 'employee_user_id')->withTrashed();
    }

    public function getStatusTextAttribute() :string{
        switch ($this->status) {
            case self::STATUS_SCHEDULED:
                return 'Scheduled';
                break;
            case self::STATUS_SELECTED_FOR_TRAIL:
                return 'Selected for Trail';
                break;
            case self::STATUS_SELECTED:
                return 'Selected';
                break;
            case self::STATUS_REJECTED_AFTER_TRAIL:
                return 'Rejected after trail';
                break;
            case self::STATUS_REJECTED_IN_INTERVIEW:
                return 'Rejected in interview';
                break;
            
            default:
                return 'No status found';
                break;
        }
    }
}
