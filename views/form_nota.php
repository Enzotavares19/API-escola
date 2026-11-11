<div class="cabecalho-pagina">
    <div>
        <h1>Lançamento Acadêmico</h1>
        <p>Atualizando informações de: <strong><?= htmlspecialchars($dados['nome']) ?></strong></p>
    </div>
    <a href="index.php?acao=professor" class="btn btn-outline">Cancelar</a>
</div>

<div class="card" style="max-width: 500px;">
    <form action="index.php?acao=salvar_registro" method="POST">
        <input type="hidden" name="aluno_id" value="<?= $dados['aluno_id'] ?>">
        
        <div class="form-group">
            <label>Disciplina</label>
            <input type="text" name="disciplina" required value="<?= htmlspecialchars($dados['disciplina'] ?? '') ?>">
        </div>
        
        <div style="display: flex; gap: 15px;">
            <div class="form-group" style="flex: 1;">
                <label>Nota Final (0 a 10)</label>
                <input type="number" step="0.1" name="nota" min="0" max="10" required value="<?= htmlspecialchars($dados['nota'] ?? '') ?>">
            </div>
            
            <div class="form-group" style="flex: 1;">
                <label>Total de Faltas</label>
                <input type="number" name="faltas" min="0" required value="<?= htmlspecialchars($dados['faltas'] ?? '') ?>">
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">Salvar Informações</button>
    </form>
</div>
    </div>
</div> 
</body>
</html>