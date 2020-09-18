<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class RelEntidadesExport implements FromCollection,ShouldAutoSize,WithEvents,WithHeadings
{
    protected $report, $nameOrg,$desc;

    public function __construct(Collection $col, $org, $descricao)
    {
        $this->report = $col;
        $this->nameOrg = $org;
        $this->desc = $descricao;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->report;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event)
            {
                $event->getSheet()->getDelegate()->getStyle('A3:M3')->getFont()->setBold(true);
            }
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            [$this->nameOrg],
            [$this->desc],
            [
                'Situação',
                'Razão Social',
                'CNPJ/CPF',
                'Endereço',
                'Número',
                'Complemento',
                'Bairro',
                'Cidade',
                'Estado',
                'CEP',
                'Telefone',
                'Celular'
            ]
        ];
    }
}
