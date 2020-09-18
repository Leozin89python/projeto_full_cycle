<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class RelChipOperadoraExport implements FromCollection,ShouldAutoSize,WithEvents,WithHeadings,WithMapping
{
    protected $data,$desc,$orgName,$i=1;

    public function __construct($dados,$nameOrganization)
    {
        $this->data = $dados[0];
        $this->desc = $dados[1];
        $this->orgName = $nameOrganization;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event)
            {
                $event->getSheet()->getDelegate()->getStyle('A3:F3')->getFont()->setBold(true);
            }
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            [$this->orgName],
            [$this->desc],
            [
                'Nº',
                'Situação',
                '# Serial',
                'Telefone',
                'Fornecedor',
                'Tipo',
            ]
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
            $row->numero_serie,
            $row->numero_telefone,
            $row->fornecedor,
            $row->tipo,
        ];
    }
}
