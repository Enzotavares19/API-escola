<div class="cabecalho-pagina">
    <div>
        <h1>Diário do Professor</h1>
        <p>Acompanhe e atualize o desempenho acadêmico dos seus alunos.</p>
    </div>
</div>

<?php if (isset($mensagem) && $mensagem == 'sucesso'): ?>
    <div class="alert alert-success">✓ Desempenho acadêmico atualizado com sucesso!</div>
<?php endif; ?>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Nome do Aluno</th>
                <th>Disciplina Vigente</th>
                <th>Nota Atual</th>
                <th>Faltas Atuais</th>
                <th style="text-align: right;">Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alunos as $aluno): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($aluno['nome']) ?></strong></td>
                    <td><?= $aluno['disciplina'] ? htmlspecialchars($aluno['disciplina']) : '<span style="color:#94a3b8">Não Lançado</span>' ?></td>
                    <td><strong><?= $aluno['disciplina'] ? htmlspecialchars($aluno['nota']) : '-' ?></strong></td>
                    <td><?= $aluno['disciplina'] ? htmlspecialchars($aluno['faltas']) : '-' ?></td>
                    <td style="text-align: right;">
                        <a href="index.php?acao=editar_nota&id=<?= $aluno['aluno_id'] ?>" class="btn btn-primary">✏️ Lançar / Atualizar</a>
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