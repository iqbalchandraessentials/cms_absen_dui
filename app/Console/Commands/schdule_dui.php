<?php

namespace App\Console\Commands;

use App\Models\cuti_tahunan;
use App\Models\KuotaCuti;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class schdule_dui extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schdule_dui';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();
        $user = User::select('id', 'name', 'join_date')->whereNot('organization_id', 10)->where('active', 1)->get();
        $cuti_tahunan = cuti_tahunan::where('name', $now->year)->first();
        foreach ($user as $value)
        {
            if(isset($value->cuti_kuota->id)) {
                $date1 = Carbon::parse($value->join_date);
                $interval = $date1->diff($now);
                $cuti_quota = KuotaCuti::find($value->cuti_kuota->id);

                    if ($interval->y >= 1) {
                        if ($cuti_quota->kuota_cuti < 0) {
                            $cuti_quota->sisa_cuti = 0;
                            $cuti_quota->kuota_cuti = 12 - abs($cuti_quota->kuota_cuti) - $cuti_tahunan->mass_leave;
                        } else {
                            $cuti_quota->sisa_cuti = $cuti_quota->kuota_cuti;
                            $cuti_quota->kuota_cuti = 12 - $cuti_tahunan->mass_leave;
                        }
                    } else {
                        $cuti_quota->kuota_cuti = $interval->m;
                        $cuti_quota->sisa_cuti = 0;
                    }
                    $cuti_quota->save();
                }
            };
    }
}
