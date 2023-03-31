<?php

namespace App\Http\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\Order;
class Index extends Component
{
    public function render()
    {
        if(!auth()->user()->can('admin_dashboard_index')) {
            return abort(403);
        }
        $form_id = [env('FORM_ID', '')];
        $total_order = Order::whereIn('form_id', $form_id)->count();
        $total_complete_order = Order::whereIn('form_id', $form_id)->where('status','completed')->count();
        return view('livewire.admin.dashboard.index',compact('total_order','total_complete_order'))->layout('layouts.admin');
    }
}
