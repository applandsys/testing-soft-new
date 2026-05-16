<?php

namespace App\Http\Controllers;

use App\Models\TestItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TestReportController extends Controller
{
//     public function generate($group)
//     {
//         $items = TestItem::where('test_group_id', $group)->get();
//
//         $data = [
//             'date'  => Carbon::today()->format('d M Y'),
//             'items' => $items,
//         ];
//
//         return Pdf::loadView('admin.test-report-pdf', $data)
//             ->stream('test-report-' . now()->format('Y-m-d') . '.pdf');
//
//       //  return $pdf->download('test-report-' . now()->format('Y-m-d') . '.pdf');
//     }

    public function generate($group)
    {
        $items = TestItem::where('test_group_id', $group)->get();

        $data = [
            'date'  => Carbon::today()->format('d M Y'),
            'items' => $items,
        ];

        return view('admin.test-report', $data);
    }
}
