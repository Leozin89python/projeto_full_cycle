<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class RelSituacaoAdministrativaExport implements FromCollection,ShouldAutoSize,WithHeadings,WithEvents,WithMapping
{
    protected $reports,$description,$i=1;

    public function __construct(Collection $rel,$desc)
    {
        $this->reports = $rel;
        $this->description = $desc;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->reports;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            [$this->description],
            [
                'Nº',
                'Placa',
                'Fabricante',
                'Modelo',
                'Cor',
                'Entidade',
                'Situação Cadastro',
                'Situação Administrativa',
                'Equipamento',
                'Chip',
                'Número de Telefone',
            ],
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
                $event->getSheet()->getDelegate()->getStyle('A2:K2')->getFont()->setBold(true);
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
            $row->placa,
            $row->fabricante,
            $row->modelo,
            $row->cor,
            $row->entidade,
            $row->situacao,
            $row->situacao_administrativa,
            $row->eqpto_pri.'->'.$row->eqpto_sec,
            $row->numero_serie,
            $row->tel,
        ];
    }
}
