<table>
    <tr><th>{{$filtro}}</th></tr>
    <tr></tr>
    <tr>
        <th>Nº</th>
        <th>Cod. Aten.</th>
        <th>Situação</th>
        <th>Organização</th>
        <th>Entidade</th>
        <th>Técnico</th>
        <th>DH Visita</th>
        <th>Itens Manutenção</th>
        <th>DH Cadastro</th>
        <th>Operador Cadastro</th>
        <th>DH Atualizacao</th>
        <th>DH Concluido</th>
        <th>Operador Ultima Atualização</th>
        <th>Contato Local</th>
        <th>Telefone Contato</th>
    </tr>
    @for($i=0;$i < $dados->count();$i++)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $dados[$i]->cod_atendimento }}</td>
            <td>{{ $dados[$i]->situacao }}</td>
            <td>{{ $dados[$i]->organizacao }}</td>
            <td>{{ $dados[$i]->entidade }}</td>
            <td>{{ $dados[$i]->tecnico ==! "null" ? "--" :  $dados[$i]->tecnico }}</td>
            <td>{{ $dados[$i]->dh_visita }}</td>
            <td>{{ $dados[$i]->itens_manutencao }}</td>
            <td>{{ $dados[$i]->dh_cadastro }}</td>
            <td>{{ $dados[$i]->usuario_cadastro }}</td>
            <td>{{ $dados[$i]->dh_atualizacao }}</td>
            <td>{{ $dados[$i]->dh_concluido ==! "null" ? "--" : $dados[$i]->dh_concluido }}</td>
            <td>{{ $dados[$i]->usuario_atualizacao }}</td>
            <td>{{ $dados[$i]->contato_local }}</td>
            <td>{{ $dados[$i]->telefone_contato_local }}</td>
        </tr>
        <tr></tr>
        {{ $itens = $nucleo->itensOs($dados[$i]->id) }}
        @for($f=0;$f < $itens->count();$f++)
            <tr>
                <th></th>
                <th>Placa</th>
                <th>Serviço</th>
                <th>Equi. Atual</th>
                <th>Equi. Novo</th>
                <th>Conclusão</th>
                <th>Info</th>
            </tr>
            <tr>
                <td></td>
                <td>{{ $itens[$f]->placa }}</td>
                <td>{{ $itens[$f]->servico }}</td>
                <td>{{ $itens[$f]->equipamento_atual }}</td>
                <td>{{ $itens[$f]->equipamento_subs }}</td>
                <td>{{ $itens[$f]->operador_conclusao . " - " . $itens[$f]->dh_concluido }}</td>
                <td>{{ $itens[$f]->info }}</td>
            </tr>
            <tr></tr>
        @endfor
    @endfor
</table>