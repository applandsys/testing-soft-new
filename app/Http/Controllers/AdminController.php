<?php

namespace App\Http\Controllers;

use App\Models\TestItem;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function testPage($group){
        $test_items = TestItem::where('test_group_id', $group)->get();
        return view('admin.testpage', compact('test_items'));
    }
    public function testPagePause($group){
        $test_items = TestItem::where('test_group_id', $group)->get();
        return view('admin.testpage-pause', compact('test_items'));
    }

    public function testPageOne($group){
        $test_items = TestItem::where('test_group_id', $group)->get();
        return view('admin.testpage-one', compact('test_items'));
    }

    public function testPageFour($group){
        $test_items = TestItem::where('test_group_id', $group)->get();
        return view('admin.testpage-four', compact('test_items'));
    }
}
