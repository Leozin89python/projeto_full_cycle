<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class RelSituacaoAdmDataExport implements FromCollection,ShouldAutoSize,WithHeadings,WithEvents,WithMapping
{
    protected $relatorio,$descricao,$i=1;

    public function __construct(Collection $col,$desc)
    {
        $this->relatorio = $col;
        $this->descricao = $desc;
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
                $event->getSheet()->getDelegate()->getStyle('A3:H3')->getFont()->setBold(true);
            }
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            [$this->descricao],
            [],
            [
                "Nº",
                "PLaca",
                "Fabricante",
                "Modelo",
                "Cor",
                "Entidade",
                "Situação Cadastro",
                "Situação Administrativa"
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
            $row->placa,
            $row->fabricante,
            $row->modelo,
            $row->cor,
            $row->entidade,
            $row->situacao,
            $row->situacao_administrativa,
        ];
    }
}
