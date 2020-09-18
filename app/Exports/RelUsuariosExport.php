<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class RelUsuariosExport implements FromCollection,ShouldAutoSize,WithHeadings,WithEvents,WithMapping
{
    protected $relatorio,$nameOrg,$filtro_desc,$i=1;

    public function __construct(Collection $col,$orgName,$description)
    {
        $this->relatorio = $col;
        $this->nameOrg = $orgName;
        $this->filtro_desc = $description;
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
            [$this->nameOrg],
            [$this->filtro_desc],
            [
                'Nº',
                'Ativo',
                'Nome Completo',
                'Login',
                'E-Mail',
                'Grupo',
                'Último Acesso',
                'Validade',
            ],
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
            $row->ativo ? 'Sim' : 'Não',
            $row->nome_completo,
            $row->user_login,
            $row->user_email,
            $row->descricao,
            $row->dh_ultimo_acesso,
            $row->validade,
        ];
    }
}
