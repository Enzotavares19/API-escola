<div class="cabecalho-pagina">
    <div>
        <h1>Editar Aluno</h1>
        <p>Atualize os dados de acesso e identificação do estudante.</p>
    </div>
    <a href="index.php?acao=dashboard" class="btn btn-outline">Voltar</a>
</div>

<div class="card" style="max-width: 600px;">
    <form action="index.php?acao=atualizar_aluno" method="POST">
        <input type="hidden" name="id" value="<?= $aluno['id'] ?>">
        
        <div class="form-group">
            <label>Nome Completo</label>
            <input type="text" name="nome" required value="<?= htmlspecialchars($aluno['nome']) ?>">
        </div>
        
        <div class="form-group">
            <label>E-mail</label>
            <input type="email" name="email" required value="<?= htmlspecialchars($aluno['email']) ?>">
        </div>
        
        <div class="form-group">
            <label>Nova Senha (deixe em branco para manter a atual)</label>
            <input type="password" name="senha" placeholder="Apenas se quiser alterar">
        </div>
        
        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary" style="flex: 1;">Salvar Alterações</button>
        </div>
    </form>
</div>
    </div>
</div> 
</body>
</html>