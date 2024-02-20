<?php

namespace App\Helpers;

use App\Models\Department;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
/**
 * Format response.
 */
class ImageIntervention
{
    public static function compress($request, $folder)
    {
        $imageNamedepan   = $request->getClientOriginalName();
        $extension = $request->getClientOriginalExtension();
        $rand = rand(0, 99999);
        $destinationPath = public_path('uploads/'.$folder);
        $img = Image::make($request->path());
        $img->resize(1000, 1000, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $rand . trim($imageNamedepan));
        return $rand. trim($imageNamedepan);
    }

    public static function catOrg($id, $column = null, $param= null)
    {
        if ($column) {
            return User::where('active', 1)->where('organization_id', $id)->whereIn($column, $param)->get();
        } else {
            return User::where('active', 1)->where('organization_id', $id)->get();
        }
    }

    public static function getDept($id)
    {
        $getName = Department::select(['name'])->find($id);
        return Str::slug($getName);
    }


    public static function userFormat($data)
    {
        function cekKosong($value)
        {
            if (empty($value) || !isset($value)) {
                return '-';
            } else {
                return $value->name;
            }
        }
        foreach ($data as $value) {
            if(!isset($value->manager_id)){
                $value->manager = '-';
            }
            else{
                $value->manager = $value->manager->name;
            }
            if(!isset($value->approval_line_id)){
                $value->approval_line = '-';
            }
            else{
                $value->approval_line = $value->approval_line->name;
            }
            $value->department = cekKosong($value->department);
            $value->division = cekKosong($value->division);
            $value->level = cekKosong($value->level);
            $value->location = cekKosong($value->location);
            $value->position = cekKosong($value->position);
            $value->organization = cekKosong($value->organization);
        }
        return $data;
    }

    public static function countTimeoff($absent)
    {
            $cuti = (object)[
                'CT' => $absent->where('status','CT')->count(),
                'CB' => $absent->where('status','CB')->count(),
                'CM' => $absent->where('status','CM')->count(),
                'CMA' => $absent->where('status','CMA')->count(),
                'CKA' => $absent->where('status','CKA')->count(),
                'CBA' => $absent->where('status','CBA')->count(),
                'CIM' => $absent->where('status','CIM')->count(),
                'CKM' => $absent->where('status','CKM')->count(),
                'CRM' => $absent->where('status','CRM')->count(),
                'CL' => $absent->where('status','CL')->count(),
                'CH' => $absent->where('status','CH')->count(),
                'CK' => $absent->where('status','CK')->count(),
                'CIH' => $absent->where('status','CIH')->count(),
                'CKTN' => $absent->where('status','CKTN')->count(),
                'CTSPB' => $absent->where('status','CTSPB')->count(),
                'CTPDP' => $absent->where('status','CTPDP')->count(),
                'SDSD' => $absent->where('status','SDSD')->count(),
                'ISH' => $absent->where('status','ISH')->count(),
                'DLK' => $absent->where('status','DLK')->count(),
                'UL' => $absent->where('status','UL')->count(),
                'STSD' => $absent->where('status','STSD')->count(),
                'CR' => $absent->where('status','CR')->count(),
                'CFM' => $absent->where('status','CFM')->count(),
                ];
            return $cuti;

    }


}
