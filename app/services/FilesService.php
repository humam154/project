<?php

namespace App\services;

use App\Models\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FilesService
{

    protected function create()
    {
        $year = Carbon::now()->format('Y');

        $info = DB::select('
        SELECT * FROM employees e
        JOIN salaries s ON e.salary_id = s.id
        JOIN salary_grades sg ON s.grade_id = sg.id
        ');
        $file = File::query()->create([
            'name' => $year,

        ]);
    }
}
