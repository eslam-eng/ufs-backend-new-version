<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Company;
use App\Models\Location;
use Illuminate\Database\Seeder;

class BranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company_id = Company::first()->id ;
        $city_id = Location::withDepth()->having('depth', '=', 1)->first()->id; // المحافظات
        $area_id = Location::withDepth()->having('depth', '=', 2)->first()->id; //المدن
        Branch::create([
            'name' => 'branch 1 test',
            'company_id' => $company_id,
            'city_id' => $city_id,
            'area_id' => $area_id,
            'phone'=>'01113622098'
        ]);
    }
}
