<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class RelAuditoriaExport implements FromCollection,ShouldAutoSize,WithEvents,WithHeadings,WithMapping
{
    protected $dados,$description,$i=1;

    public function __construct($data)
    {
        $this->dados = $data[0];
        $this->description = $data[1];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->dados;
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
     * @return array
     */
    public function headings(): array
    {
        return [
            [$this->description],
            [
                'Nº',
                'Data do Evento',
                'Operador',
                'Entidade',
                'Veiculo',
                'Equipamento',
                'Sim Card',
                'Usuario',
                'Ação',
                'Informação',
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
            $row->dh_cadastro,
            $row->operador_login,
            $row->entidade,
            $row->placa,
            $row->equipamento,
            $row->simcard_serie,
            $row->usuario_nome,
            $row->acao,
            $row->informacao,
        ];
    }
}
