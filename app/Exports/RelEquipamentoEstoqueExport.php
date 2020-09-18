<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class RelEquipamentoEstoqueExport implements FromCollection,ShouldAutoSize,WithHeadings,WithEvents,WithMapping
{
    protected $relatorio,$orgName,$i=1;

    public function __construct(Collection $collection, $organizationName)
    {
        $this->relatorio = $collection;
        $this->orgName = $organizationName;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->relatorio;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            [$this->orgName],
            [],
            [
                'Nº',
                'Situação',
                '# Serial',
                'SIM Card',
                'Modelo',
                'Estoque',
                'Técnico',
                'Placa',
                'Entidade'
            ]
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event)
            {
                $event->getSheet()->getDelegate()->getStyle('A3:I3')->getFont()->setBold(true);
            }
        ];
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        return [
            $this->i++,
            $row->situacao,
            $row->equipamento_serial,
            $row->sim_serial,
            $row->modelo,
            $row->estoque,
            $row->tecnico,
            $row->placa,
            $row->entidade,
        ];
    }
}
