<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class RelEquipamentosExport implements FromCollection,ShouldAutoSize,WithHeadings,WithEvents,WithMapping
{
    protected $relatorio,$i=1;

    public function __construct(Collection $collection)
    {
        $this->relatorio = $collection;
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
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event)
            {
                $event->getSheet()->getDelegate()->getStyle('A1:J1')->getFont()->setBold(true);
            }
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nº',
            'Situação',
            '# Serial',
            'Fabricante',
            'Modelo',
            'SIM Card',
            'Telefone',
            'Entidade',
            'Placa',
            //'Transmissão'
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
            $row->fabricante,
            $row->modelo,
            $row->sim_serial,
            $row->telefone,
            $row->entidade,
            $row->placa,
            //$row->transmissao
        ];
    }
}
