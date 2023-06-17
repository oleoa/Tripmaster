<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Money extends Controller
{
  public function manage()
  {
    $this->data->title('Manage money');
    $balance = User::find(Auth::id())->money;
    $this->data->set('balance', $balance);
    return $this->view('money.manage');
  }

  public function adder()
  {
    $this->data->title('Add money');
    $this->data->set("btnText", "Add");
    $this->data->set("btnColor", "good");
    $this->data->set("action", route('account.money.add'));
    return $this->view('money.add_or_remove');
  }
  
  public function remover()
  {
    $this->data->title('Remove money');
    $this->data->set("btnText", "Remove");
    $this->data->set("btnColor", "danger");
    $this->data->set("action", route('account.money.remove'));
    return $this->view('money.add_or_remove');
  }

  public function add(Request $request)
  {
    $validated = $request->validate([
      'amount' => 'required|numeric|min:0|max:1000000',
    ]);

    $user = User::find(Auth::id());
    $user->money += $validated['amount'];
    $user->save();

    session()->flash('success', $validated['amount'].'€ added successfully!');
    return redirect()->route('account.manage.money');
  }

  public function remove(Request $request)
  {
    $validated = $request->validate([
      'amount' => 'required|numeric|min:0|max:1000000',
    ]);

    $user = User::find(Auth::id());
    $user->money -= $validated['amount'];
    $user->save();

    session()->flash('success', $validated['amount'].'€ removed successfully!');
    return redirect()->route('account.manage.money');
  }
}
