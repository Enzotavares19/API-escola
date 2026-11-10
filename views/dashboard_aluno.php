<div class="cabecalho-pagina">
    <div>
        <h1>Meu Portal</h1>
        <p>Bem-vindo(a), <strong><?= htmlspecialchars($boletim[0]['nome'] ?? 'Aluno') ?></strong>. Acompanhe seu progresso.</p>
    </div>
</div>
<div class="card">
    <?php if (empty($boletim[0]['disciplina'])): ?>
        <p style="color: var(--text-muted); text-align: center; padding: 20px;">Os professores ainda não lançaram seu boletim.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Matéria</th>
                    <th>Nota Final</th>
                    <th>Ausências</th>
                    <th>Mensagem da Direção</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($boletim as $b): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($b['disciplina']) ?></strong></td>
                        <td style="font-size: 16px;"><strong><?= htmlspecialchars($b['nota']) ?></strong></td>
                        <td><?= htmlspecialchars($b['faltas']) ?> faltas</td>
                        <td>
                            <?php if($b['faltas'] >= 15 || $b['nota'] < 5): ?>
                                <span style="color: var(--danger); font-weight: 600; display: flex; align-items: center; gap: 5px;">Por favor, procure a coordenação.</span>
                            <?php else: ?>
                                <span style="color: var(--success); font-weight: 600; display: flex; align-items: center; gap: 5px;">Desempenho adequado</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</div>
</body>
</html>