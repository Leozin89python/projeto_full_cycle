<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class RelVeiculosExport implements FromCollection,ShouldAutoSize,WithHeadings,WithEvents,WithMapping
{
    protected $rels,$nameOrg,$desc,$i=1;

    public function __construct(Collection $report, $org, $descricao)
    {
        $this->rels = $report;
        $this->nameOrg = $org;
        $this->desc = $descricao;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->rels;
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
            $row->placa,
            $row->fabricante,
            $row->modelo,
            $row->cor,
            $row->entidade,
            $row->situacao,
            $row->eqpto_pri,
            $row->eqpto_sec,
            $row->chassi,
            $row->tipo_veiculo,
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
                $event->getSheet()->getDelegate()->getStyle('A3:K3')->getFont()->setBold(true);
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
                'Nº',
                'Placa',
                'Fabricante',
                'Modelo',
                'Cor',
                'Entidade',
                'Situação',
                'Equipamento 1',
                'Equipamento 2',
                'Chassi',
                'Tipo de Veículo',
            ],
        ];
    }
}
