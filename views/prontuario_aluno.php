<div class="cabecalho-pagina">
    <div>
        <h1>Prontuário do Aluno</h1>
        <p>Ações e intervenções realizadas para: <strong><?= htmlspecialchars($nomeAluno) ?></strong></p>
    </div>
    <div>
        <a href="index.php?acao=dashboard" class="btn btn-outline" style="margin-right: 10px;">Voltar</a>
        <a href="index.php?acao=intervir&id=<?= htmlspecialchars($aluno_id) ?>" class="btn btn-primary">Nova Ação</a>
    </div>
</div>
<div class="card">
    <?php if (empty($historico)): ?>
        <p style="color: var(--text-muted); text-align: center; padding: 20px;">O aluno não possui histórico de intervenções.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th style="width: 220px;">Data e Hora do Registro</th>
                    <th>Descrição da Intervenção Escolar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historico as $registro): ?>
                    <tr>
                        <td>
                            <strong style="color: var(--dark); font-size: 15px;"><?= date('d/m/Y', strtotime($registro['data_registro'])) ?></strong><br>
                            <span style="font-size: 13px; color: var(--text-muted);">às <?= date('H:i', strtotime($registro['data_registro'])) ?></span>
                        </td>
                        <td style="line-height: 1.5; color: var(--text-main);"><?= nl2br(htmlspecialchars($registro['descricao'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</div>
</body>
</html>