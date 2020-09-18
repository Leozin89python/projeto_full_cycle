<?php

namespace App\Exports;


use App\Models\Relatorios\RelNucleo;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class RelNucleoExport implements FromView,ShouldAutoSize,WithEvents
{
    protected $results,$description;

    public function __construct($datas,$desc)
    {
        $this->results = $datas;
        $this->description = $desc;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return \view('relNucleo')->with([
            'nucleo' => new RelNucleo(),
            'dados' => $this->results,
            'filtro' => $this->description
        ]);
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event)
            {
                $event->getSheet()->getDelegate()->getStyle('A3:O3')->getFont()->setBold(true);
                $event->getSheet()->getDelegate()->getStyle('A3:O3')->getFill()->setFillType('solid');
                $event->getSheet()->getDelegate()->getStyle('A3:O3')->getFill()->getStartColor()->setRGB('E0E0E0');
            }
        ];
    }
}
