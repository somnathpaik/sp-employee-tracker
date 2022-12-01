<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserSkills;
use App\Models\UserEducation;
use App\Models\UserExperince;
use App\Models\Certification;
use App\Models\LearningSkills;
use App\Models\userAchievement;
use App\Models\UserProject;
use App\Models\Teams;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read string $full_name
 * @property-read NoticeManagement $noticeManagement 
 */

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    public CONST ADMIN_EMAILS = [
        'admin@virtualemployee.com',
        'admin@dev.com',
        'anshulsehgal@virtualemployee.com',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_name',
        'employee_id',
        'resume_title',
        'mobile',
        'joining_date',
        'shift_start',
        'shift_end',
        'team',
        'about_employee',
        'experience',
        'resume_emp_id',
        'work_type',
        'client_status',
        'updated_by',
        'check_password',
        'added_by',
        'user_role',
        'click_up_user_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = ['deleted_at'];

   
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected $appends = [
        'full_name'
    ];

    public function getEmployeeIdAttribute($value)
    {
        return strtoupper($value);
    }
  
    public function getResumeTitleAttribute($value)
    {
        return strtoupper($value);
    }
   

    public function skills(){
        return $this->hasMany(UserSkills::class, 'user_id', 'id')->with('skills_details')->orderBy('type', 'asc');

    }

    
    
    public function portfolio(){
        return $this->hasMany(UserPortfolio::class, 'user_id', 'id');

    }

    public function education(){
        return $this->hasMany(UserEducation::class, 'user_id', 'id');

    }
    public function certification(){
        return $this->hasMany(Certification::class, 'user_id', 'id');

    }
    public function exprince(){
        return $this->hasMany(UserExperince::class, 'user_id', 'id');

    }
     
    public function learning_skills(){
        return $this->hasMany(LearningSkills::class, 'user_id', 'id')->with('skills_details');

    }
    public function achievement(){
        return $this->hasMany(userAchievement::class, 'user_id', 'id');

    }

    public function project(){
        return $this->hasMany(UserProject::class, 'user_id', 'id');

    }
    
    public function myTeam(){
        return $this->belongsTo(Teams::class, 'team', 'id');

    }

    
    
    public function client_status_value(){
        return $this->hasMany(ClientStatus::class, 'id', 'client_status');

    }
    public function work_status_value(){
        return $this->hasMany(WorkType::class, 'id', 'work_type');

    }
    public function created_by(){
        return $this->belongsTo(User::class, 'added_by','id');

    }
    public function change_by(){
        return $this->belongsTo(User::class, 'updated_by','id');

    }
    public function miscellaneous(){
        return $this->hasOne(Miscellaneous::class, 'user_id', 'id');

    }
    public function onFrontEnd()
    {
        return $this->hasMany('App\Models\ClientResource', 'hire_user_id')->where('status','Active');
    }
    public function onBackEnd()
    {
        return $this->hasMany('App\Models\ClientResource', 'working_user_id')->where('status','Active');
    }

    public function getFullNameAttribute(): string{
        return "{$this->name} {$this->last_name}";
    }
    
    public function noticeManagement() :HasOne{
        return $this->hasOne(NoticeManagement::class);
    }

    public function interview() :HasOne{
        return $this->hasOne(Interview::class);
    }

    public function interviewAdminUser() :HasMany{
        return $this->hasMany(InterviewLog::class, 'admin_user_id');
    }

    public function interviewEmployeeUser() :HasMany{
        return $this->hasMany(InterviewLog::class, 'employee_user_id');
    }
}
