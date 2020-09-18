<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class RelOsNucleoExport implements FromCollection,ShouldAutoSize,WithHeadings,WithEvents,WithMapping
{
    protected $relatorio,$desc,$i=1;

    public function __construct($dados,$filtro)
    {
        $this->relatorio = $dados;
        $this->desc = $filtro;
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
            [$this->desc],
            [],
            [
                'Nº',
                'Cod. Atend',
                'DH Concluido',
                'Veículo',
                'Serviço',
                'Valor/KM',
                'Origem',
                'Destino',
                'Itens',
                'Info',
                'Despesas',
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
                $event->getSheet()->getDelegate()->getStyle('A3:K3')->getFont()->setBold(true);
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
        $servico = '';
        $itens = 0;

        if ($row->servico === 'I'){
            $servico = 'Instalação R$ '.number_format($row->isntalacao,2);
        }elseif ($row->servico === 'R'){
            $servico = 'Retirada: R$ '. number_format($row->retirada,2);
        }elseif ($row->servico === 'S'){
            $servico = 'Substituicão: R$ '. number_format($row->substituicao,2);
        }elseif ($row->servico === 'V'){
            $servico = 'Verficação: R$ '. number_format($row->verificacao,2);
        }elseif ($row->servico === 'A'){
            $servico = 'Inst sem bloqueio: R$ '. number_format($row->instalacao_sem_bloqueio,2);
        }elseif ($row->servico === 'B'){
            $servico = 'Periferica: R$ '. number_format($row->segp,2);
        }elseif ($row->servico === 'c'){
            $servico = 'Satelital: R$ '. number_format($row->satelital,2);
        }

        if ($row->servico === 'I'){
            $itens = $row->itens_retirada;
        }elseif ($row->servico === 'R'){
            $itens = $row->itens_retirada;
        }elseif ($row->servico === 'S'){
            $itens =$row->itens_retirada;
        }elseif ($row->servico === 'V'){
            $itens = $row->itens_retirada;
        }elseif ($row->servico === 'A'){
            $itens = $row->itens_retirada;
        }elseif ($row->servico === 'B'){
            $itens = $row->itens_retirada;
        }elseif ($row->servico === 'c'){
            $itens = $row->itens_retirada;
        }

        return [
            $this->i++,
            $row->cod_atendimento,
            $row->dh_concluido,
            $row->placa,
            $servico,
            $row->km_valor,
            $row->cidade_origem,
            $row->cidade_destino,
            $itens,
            $row->info,
            $row->despesas,
        ];
    }
}
