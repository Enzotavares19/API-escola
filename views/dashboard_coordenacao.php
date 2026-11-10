<div class="cabecalho-pagina">
    <div>
        <h1>Monitoramento de Evasão</h1>
        <p>Visão estratégica de risco e retenção escolar.</p>
    </div>
    <a href="index.php?acao=novo_aluno" class="btn btn-primary">Novo Aluno</a>
</div>

<?php if (isset($mensagem)): ?>
    <?php if ($mensagem == 'intervencao_ok'): ?>
        <div class="alert alert-success">✓ Intervenção registrada com sucesso no prontuário do aluno.</div>
    <?php elseif ($mensagem == 'aluno_criado'): ?>
        <div class="alert alert-success">✓ Novo aluno matriculado com sucesso no sistema.</div>
    <?php elseif ($mensagem == 'aluno_atualizado'): ?>
        <div class="alert alert-success">✓ Dados do aluno atualizados com sucesso.</div>
    <?php elseif ($mensagem == 'aluno_excluido'): ?>
        <div class="alert alert-success">✓ Aluno e seu histórico foram removidos do sistema.</div>
    <?php endif; ?>
<?php endif; ?>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Aluno</th>
                <th>Status Disciplinar</th>
                <th>Risco de Evasão</th>
                <th style="text-align: right;">Ações de Gestão</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alunosMonitorados as $aluno): ?>
                <?php $classeRisco = $aluno['risco_evasao'] == 'Alto' ? 'risco-alto' : ($aluno['risco_evasao'] == 'Médio' ? 'risco-medio' : 'risco-baixo'); ?>
                <tr>
                    <td>
                        <strong style="display: block; font-size: 15px; color: #0f172a;"><?= htmlspecialchars($aluno['nome']) ?></strong>
                        <span style="font-size: 13px; color: #64748b;">ID: #<?= $aluno['id'] ?> | <?= htmlspecialchars($aluno['email']) ?></span>
                    </td>
                    <td>
                        <?php if($aluno['disciplina']): ?>
                            <span style="font-size: 14px;">Média: <strong><?= htmlspecialchars($aluno['nota']) ?></strong> | Faltas: <strong><?= htmlspecialchars($aluno['faltas']) ?></strong></span>
                        <?php else: ?>
                            <span style="font-size: 14px; color: #94a3b8;">Sem dados lançados</span>
                        <?php endif; ?>
                    </td>
                    <td><span class="badge <?= $classeRisco ?>"><?= $aluno['risco_evasao'] ?></span></td>
                    <td style="text-align: right;">
                        <div style="display: flex; gap: 5px; justify-content: flex-end;">
                            <?php if ($aluno['risco_evasao'] == 'Alto'): ?>
                                <a href="index.php?acao=intervir&id=<?= $aluno['id'] ?>" class="btn btn-red" title="Registrar Intervenção" style="padding: 6px 10px;">⚠️</a>
                            <?php endif; ?>
                            <a href="index.php?acao=prontuario&id=<?= $aluno['id'] ?>" class="btn btn-outline" title="Ver Prontuário" style="padding: 6px 10px;">📄</a>
                            <a href="index.php?acao=editar_aluno&id=<?= $aluno['id'] ?>" class="btn btn-primary" title="Editar Aluno" style="padding: 6px 10px;">✏️</a>
                            <a href="index.php?acao=excluir_aluno&id=<?= $aluno['id'] ?>" class="btn btn-red" onclick="return confirm('Tem certeza que deseja excluir este aluno e TODO o seu histórico?');" title="Excluir Aluno" style="padding: 6px 10px;">🗑️</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
    </div> 
</div> 
</body>
</html>