<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class RelOrganizacoesExport implements FromCollection,ShouldAutoSize,WithHeadings,WithEvents
{
    protected $rel;

    public function __construct(Collection $rel)
    {
        $this->rel = $rel;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->rel;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Situação',
            'Razão Social',
            'Telefone A',
            'Telefone B',
            'Celular A',
            'Celular B',
            'Email Financeiro'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event)
            {
                $event->getSheet()->getDelegate()->getStyle('A1:G1')->getFont()->setBold(true);
            }
        ];
    }
}
