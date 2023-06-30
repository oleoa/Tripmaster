<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reports;
use App\Models\Stay_Reviews;

class Report extends Controller
{
  public function review($id)
  {
    $report = new Reports;
    $report->user = auth()->user()->id;
    $report->review = $id;
    $report->date = date('Y-m-d');
    $report->save();

    $review = Stay_Reviews::find($id);
    $review->avaiable = false;
    $review->save();

    session()->flash('success', $this::VIEW_REPORTED);
    return redirect()->back();
  }
}
