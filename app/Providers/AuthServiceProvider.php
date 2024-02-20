<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // internal memo
        Gate::define('view-internal-memo', 'App\Policies\UserPolicy@viewinternalmemo');
        Gate::define('edit-internal-memo', 'App\Policies\UserPolicy@editinternalmemo');
        Gate::define('create-internal-memo', 'App\Policies\UserPolicy@createinternalmemo');
        // location
        Gate::define('view-location', 'App\Policies\UserPolicy@viewlocation');
        Gate::define('edit-location', 'App\Policies\UserPolicy@editlocation');
        Gate::define('create-location', 'App\Policies\UserPolicy@createlocation');
        // schedule
        Gate::define('view-schedule', 'App\Policies\UserPolicy@viewschedule');
        Gate::define('edit-schedule', 'App\Policies\UserPolicy@editschedule');
        Gate::define('create-schedule', 'App\Policies\UserPolicy@createschedule');
        // businessunit
        Gate::define('view-businessunit', 'App\Policies\UserPolicy@viewbusinessunit');
        Gate::define('edit-businessunit', 'App\Policies\UserPolicy@editbusinessunit');
        Gate::define('create-businessunit', 'App\Policies\UserPolicy@createbusinessunit');
        // department
        Gate::define('view-department', 'App\Policies\UserPolicy@viewdepartment');
        Gate::define('edit-department', 'App\Policies\UserPolicy@editdepartment');
        Gate::define('create-department', 'App\Policies\UserPolicy@createdepartment');
        // division
        Gate::define('view-division', 'App\Policies\UserPolicy@viewdivision');
        Gate::define('edit-division', 'App\Policies\UserPolicy@editdivision');
        Gate::define('create-division', 'App\Policies\UserPolicy@createdivision');
        // employee
        Gate::define('view-employee', 'App\Policies\UserPolicy@viewemployee');
        Gate::define('edit-employee', 'App\Policies\UserPolicy@editemployee');
        Gate::define('create-employee', 'App\Policies\UserPolicy@createemployee');
        // level
        Gate::define('view-level', 'App\Policies\UserPolicy@viewlevel');
        Gate::define('edit-level', 'App\Policies\UserPolicy@editlevel');
        Gate::define('create-level', 'App\Policies\UserPolicy@createlevel');
        // jobposition
        Gate::define('view-jobposition', 'App\Policies\UserPolicy@viewjobposition');
        Gate::define('edit-jobposition', 'App\Policies\UserPolicy@editjobposition');
        Gate::define('create-jobposition', 'App\Policies\UserPolicy@createjobposition');
        // roster
        Gate::define('view-roster', 'App\Policies\UserPolicy@viewroster');
        Gate::define('edit-roster', 'App\Policies\UserPolicy@editroster');
        Gate::define('create-roster', 'App\Policies\UserPolicy@createroster');
        // timeoff
        Gate::define('view-timeoff', 'App\Policies\UserPolicy@viewtimeoff');
        Gate::define('edit-timeoff', 'App\Policies\UserPolicy@edittimeoff');
        Gate::define('create-timeoff', 'App\Policies\UserPolicy@createtimeoff');
        // reportattendance
        Gate::define('view-reportabsence', 'App\Policies\UserPolicy@viewreportabsence');
        Gate::define('edit-reportabsence', 'App\Policies\UserPolicy@editreportabsence');
        // overtime
        Gate::define('view-overtime', 'App\Policies\UserPolicy@viewovertime');
        Gate::define('edit-overtime', 'App\Policies\UserPolicy@editovertime');
        // reporttimeoff
        Gate::define('view-reporttimeoff', 'App\Policies\UserPolicy@viewreporttimeoff');
        Gate::define('edit-reporttimeoff', 'App\Policies\UserPolicy@editreporttimeoff');
        // outofrange
        Gate::define('view-outofrange', 'App\Policies\UserPolicy@viewoutofrange');
        Gate::define('edit-outofrange', 'App\Policies\UserPolicy@editoutofrange');
        // attendance
        Gate::define('view-attendance', 'App\Policies\UserPolicy@viewattendance');
        Gate::define('edit-attendance', 'App\Policies\UserPolicy@editattendance');
        //hak akses
        Gate::define('hak-akses', 'App\Policies\UserPolicy@hakakses');
        Gate::define('approval-ga', 'App\Policies\UserPolicy@approval_GA');
        Gate::define('superadmin-ga', 'App\Policies\UserPolicy@superadmin_GA');
        // export excel
        Gate::define('export-division', 'App\Policies\UserPolicy@exportdivision');
        Gate::define('export-department', 'App\Policies\UserPolicy@exportdepartment');
        Gate::define('export-location', 'App\Policies\UserPolicy@exportlocation');
        Gate::define('export-business', 'App\Policies\UserPolicy@exportbusiness');
        Gate::define('export-schedule', 'App\Policies\UserPolicy@exportschedule');
        Gate::define('export-employee', 'App\Policies\UserPolicy@exportemployee');
        Gate::define('export-level', 'App\Policies\UserPolicy@exportlevel');
        Gate::define('export-attendance', 'App\Policies\UserPolicy@exportattendance');
        Gate::define('export-reportovertime', 'App\Policies\UserPolicy@exportreportovertime');
        Gate::define('export-reporttimeoff', 'App\Policies\UserPolicy@exportreporttimeoff');
        Gate::define('export-reportoutofrange', 'App\Policies\UserPolicy@exportreportoutofrange');
        Gate::define('export-reportattendance', 'App\Policies\UserPolicy@exportreportattendance');
    }
}
