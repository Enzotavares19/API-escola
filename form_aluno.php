<div class="cabecalho-pagina">
    <div>
        <h1>Matricular Novo Aluno</h1>
        <p>Adicione um novo estudante à base de monitoramento da escola.</p>
    </div>
    <a href="index.php?acao=dashboard" class="btn btn-outline">Voltar</a>
</div>
<div class="card" style="max-width: 600px;">
    <form action="index.php?acao=salvar_aluno" method="POST">
        <div class="form-group">
            <label>Nome Completo do Aluno</label>
            <input type="text" name="nome" required placeholder="Ex: João da Silva">
        </div>
        <div class="form-group">
            <label>E-mail Institucional ou Pessoal</label>
            <input type="email" name="email" required placeholder="joao@escola.com">
        </div>
        <div class="form-group">
            <label>Senha de Acesso Inicial</label>
            <input type="password" name="senha" required placeholder="Defina uma senha">
        </div>
        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary" style="flex: 1;">Confirmar Matrícula</button>
        </div>
    </form>
</div>
</div>
</body>
</html>