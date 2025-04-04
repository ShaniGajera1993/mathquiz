<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MathQuestion;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\JsonResponse;

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

        $insertedCount = 0;
        $skippedCount = 0;

        foreach ($rows as $row) {
            $existingQuestion = MathQuestion::where([
                ['game', '=', $row[0]],
                ['difficulty', '=', $row[1]],
                ['level', '=', (int) $row[2]],
                ['question', '=', $row[3]],
            ])->exists();

            if (!$existingQuestion) {
                MathQuestion::create([
                    'game' => $row[0],
                    'difficulty' => $row[1],
                    'level' => (int) $row[2],
                    'question' => $row[3],
                    'options' => json_encode(explode(',', $row[4])),
                    'correct_answer' => $row[5],
                ]);
                $insertedCount++;
            } else {
                $skippedCount++;
            }
        }
        return back()->with('success', "Import completed. Inserted: $insertedCount, Skipped (duplicates): $skippedCount.");
    }

    public function getMathQuestions(): JsonResponse
    {
        $questions = MathQuestion::all()->groupBy(['game', 'difficulty', 'level']);

        $formattedQuestions = ['games' => []];

        foreach ($questions as $game => $difficulties) {
            foreach ($difficulties as $difficulty => $levels) {
                $formattedQuestions['games'][$game][$difficulty] = ['levels' => []];

                foreach ($levels as $level => $items) {
                    $levelData = [
                        'level' => (int) $level,
                        'questions' => $items->map(function ($item) {
                            return [
                                'question' => $item->question,
                                'options' => array_map('trim', json_decode($item->options)),
                                'correctOption' => $item->correct_answer,
                            ];
                        })->values()->toArray(),
                    ];

                    $formattedQuestions['games'][$game][$difficulty]['levels'][] = $levelData;
                }
            }
        }
        return response()->json($formattedQuestions);
    }
}
