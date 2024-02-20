<?php

namespace App\Models;

use App\Http\ShiftTraits;
// use App\Models\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Http\NotifTraits;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens;
    use NotifTraits;
    use ShiftTraits;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name",
        "order_month",
        "nik",
        "email",
        "username",
        "roles",
        "emergency_number",
        "emergency_name",
        "relationship",
        "mobile_phone",
        "organization_id",
        "location_id",
        "job_level_id",
        "division_id",
        "department_id",
        "job_position",
        "join_date",
        "resign_date",
        "status_employee",
        "end_date",
        "birth_date",
        "birth_place",
        "citizen_id_address",
        "resindtial_address",
        "NPWP",
        "PKTP_status",
        "employee_tax_status",
        "tax_config",
        "bank_name",
        "bank_account",
        "bank_account_holder",
        "bpjs_ketenagakerjaan",
        "bpjs_kesehatan",
        "citizen_id",
        "religion",
        "gender",
        "marital_status",
        "nationality_code",
        "golongan",
        "length_of_service",
        "payment_schedule",
        "approval_line_id",
        "manager_id",
        "grade",
        "class",
        "password",
        "is_updated",
        "active",
        // "nba_koperasi",
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function organization()
    {
        $data = $this->belongsTo(Organization::class, 'organization_id', 'id')->select(['id', 'name', 'code']);
        return $data;
    }
    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'id')->select(['id', 'name']);
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id')->select(['id', 'name']);
    }
    public function level()
    {
        return $this->belongsTo(Position::class, 'job_level_id', 'id')->select(['id', 'name']);
    }
    public function position()
    {
        return $this->belongsTo(JobPosition::class, 'job_position', 'id')->select(['id', 'name']);
    }
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id')->select(['id', 'name', 'longitude', 'latitude', 'radius']);
    }
    public function approval_line()
    {
        return $this->belongsTo(User::class, 'approval_line_id', 'id')->select(['id', 'name']);
    }
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id', 'id')->select(['id', 'name']);
    }
    public function cuti_kuota()
    {
        return $this->belongsTo(KuotaCuti::class, 'id', 'user_id')->where('periode', Carbon::now()->year);
    }
    public function schedules()
    {
        return $this->hasMany(user_schedules::class);
    }

    // results in a "problem", se examples below
    public function available_schedules($currentDate)
    {
        return $this->schedules()->whereDate('effective_date', '<=', $currentDate)
            ->whereDate('end_date', '>=', $currentDate);
    }

    public function todaysAttendance()
    {
        return $this->hasOne(Attendances::class, 'user_id', 'id')
            ->whereDate('check_in', now()->toDateString())
            ->select(['id', 'check_in', 'check_out', 'img_check_in', 'img_check_out', 'user_id']);
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }
}
