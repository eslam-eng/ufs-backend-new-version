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
        Branch::create([
            'name' => 'branch 1 test',
            'company_id' => $company_id,
            'phone'=>'01113622098'
        ]);
    }
}
