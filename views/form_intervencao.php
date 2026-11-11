<div class="cabecalho-pagina">
    <div>
        <h1>Registrar Intervenção</h1>
        <p>Registre a ação tomada para reter o aluno na escola.</p>
    </div>
</div>
<div class="card" style="max-width: 600px;">
    <form action="index.php?acao=intervir" method="POST">
        <input type="hidden" name="aluno_id" value="<?= htmlspecialchars($aluno_id) ?>">
        <div class="form-group">
            <label>Histórico de Contato e Ação Realizada</label>
            <textarea name="descricao" rows="6" required placeholder="Ex: Ligamos para os pais às 14h. Acordamos que o aluno usará o transporte auxiliar..."></textarea>
        </div>
        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-red" style="flex: 1;">Salvar no Prontuário</button>
            <a href="index.php?acao=dashboard" class="btn btn-outline">Cancelar</a>
        </div>
    </form>
</div>
</div>
</body>
</html>