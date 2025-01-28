<?php

namespace App\Livewire;



use App\Domain\Career\Models\Position;
use App\Domain\Career\Models\Site;
use Illuminate\View\View;
use Livewire\Component;

class OpenPositionsComponent extends Component
{



    public string $selectedSite = 'all';


    public function setSelectedSite($value): void
    {
        $this->selectedSite = $value;
    }

    public function render(): View
    {

        $sites = Site::all();

        $positions = Position::all();
        if($this->selectedSite != 'all') {
            $positions = Position::whereHas('site', function ($query) {
                $query->where('name', $this->selectedSite);
            })->get();
        }
        return view('livewire.open-positions-component')->with([
            'positions' => $positions,
            'sites' => $sites
        ]);
    }
}
