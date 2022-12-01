<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property-read User $user
 * @property int $notice_type
 * @property int $notice_level
 * @property string $reason_of_notice
 * @property-read string $notice_type_text
 * @property-read string $notice_level
 */

class NoticeManagement extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'notice_type',
        'notice_level',
        'reason_of_notice',
    ];

    public CONST NOTICE_TYPE_INTERNAL = 1;
    public CONST NOTICE_TYPE_CLIENT = 2;

    public CONST NOTICE_TYPE_ARRAY = [
        self::NOTICE_TYPE_INTERNAL => 'Internal',
        self::NOTICE_TYPE_CLIENT => 'Client',
    ];

    public CONST NOTICE_LEVEL_SOFT = 1;
    public CONST NOTICE_LEVEL_HARD = 2;
    public CONST NOTICE_LEVEL_NOT_MANAGEABLE = 3;

    public CONST NOTICE_LEVEL_ARRAY = [
        self::NOTICE_LEVEL_SOFT => 'Soft',
        self::NOTICE_LEVEL_HARD => 'Hard',
        self::NOTICE_LEVEL_NOT_MANAGEABLE => 'Not Manageable',
    ];

    protected $casts = [
        'notice_type' => 'integer',
        'notice_level' => 'integer',
    ];

    protected $appends = [
        'notice_type_text',
        'notice_level_text'
    ];

    public function user() :BelongsTo{
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function getNoticeTypeTextAttribute(): string{
        switch ($this->notice_type) {
            case self::NOTICE_TYPE_INTERNAL:
                return 'Internal';
                break;
            case self::NOTICE_TYPE_CLIENT:
                return 'Client';
                break;
            
            default:
                return '';
                break;
        }
    }

    public function getNoticeLevelTextAttribute(): string{
        switch ($this->notice_level) {
            case self::NOTICE_LEVEL_SOFT:
                return 'Soft';
                break;
            case self::NOTICE_LEVEL_HARD:
                return 'Hard';
                break;
            case self::NOTICE_LEVEL_NOT_MANAGEABLE:
                return 'Not Manageable';
                break;
            
            default:
                return '';
                break;
        }
    }
}
