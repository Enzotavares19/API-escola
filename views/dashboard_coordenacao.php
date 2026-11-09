<div class="cabecalho-pagina">
    <div>
        <h1>Monitoramento de Evasão</h1>
        <p>Visão estratégica de risco e retenção escolar.</p>
    </div>
    <a href="index.php?acao=novo_aluno" class="btn btn-primary">➕ Novo Aluno</a>
</div>
<?php if (isset($mensagem)): ?>
    <?php if ($mensagem == 'intervencao_ok'): ?>
        <div class="alert alert-success">✓ Intervenção registrada com sucesso no prontuário do aluno.</div>
    <?php elseif ($mensagem == 'aluno_criado'): ?>
        <div class="alert alert-success">✓ Novo aluno matriculado com sucesso no sistema.</div>
    <?php endif; ?>
<?php endif; ?>
<div class="card">
    <table>
        <thead>
            <tr>
                <th>Aluno</th>
                <th>Status Disciplinar</th>
                <th>Risco de Evasão</th>
                <th style="text-align: right;">Ações de Retenção</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alunosMonitorados as $aluno): ?>
                <?php $classeRisco = $aluno['risco_evasao'] == 'Alto' ? 'risco-alto' : ($aluno['risco_evasao'] == 'Médio' ? 'risco-medio' : 'risco-baixo'); ?>
                <tr>
                    <td>
                        <strong style="display: block; font-size: 15px; color: #0f172a;"><?= htmlspecialchars($aluno['nome']) ?></strong>
                        <span style="font-size: 13px; color: #64748b;">ID: #<?= $aluno['id'] ?></span>
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
                        <a href="index.php?acao=prontuario&id=<?= $aluno['id'] ?>" class="btn btn-outline" style="margin-right: 5px;">📄 Prontuário</a>
                        <?php if ($aluno['risco_evasao'] == 'Alto'): ?>
                            <a href="index.php?acao=intervir&id=<?= $aluno['id'] ?>" class="btn btn-red">⚠️ Intervir</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>
</body>
</html>