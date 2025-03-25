<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MathQuestion;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MathQuestionController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $spreadsheet = IOFactory::load($request->file('file')->path());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        array_shift($rows);

        foreach ($rows as $row) {
            MathQuestion::create([
                'game' => $row[0],
                'difficulty' => $row[1],
                'level' => (int) $row[2],
                'question' => $row[3],
                'options' => json_encode(explode(',', $row[4])),
                'correct_answer' => $row[5],
            ]);
        }

        return back()->with('success', 'Math questions imported successfully.');
    }
}
