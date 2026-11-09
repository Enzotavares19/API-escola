<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>EduTech - Monitoramento Escolar</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        :root {
            --primary: #4f46e5; --primary-hover: #4338ca;
            --dark: #0f172a; --dark-lighter: #1e293b;
            --bg-color: #f8fafc; --card-bg: #ffffff;
            --text-main: #334155; --text-muted: #64748b;
            --border: #e2e8f0;
            --danger: #ef4444; --danger-hover: #dc2626;
            --success: #10b981; --warning: #f59e0b;
        }

        body { font-family: 'Inter', sans-serif; background-color: var(--bg-color); margin: 0; color: var(--text-main); }
        
        /* TRUQUE PARA FECHAR MENU SEM JS */
        #menu-toggle { display: none; }
        .app-wrapper { display: flex; width: 100%; min-height: 100vh; }
        
        /* === MENU LATERAL (ABERTO) === */
        .sidebar { 
            width: 260px; 
            background-color: var(--dark); 
            color: white; 
            display: flex; 
            flex-direction: column; 
            transition: width 0.3s ease; 
            overflow: hidden; 
            white-space: nowrap; 
            box-shadow: 2px 0 5px rgba(0,0,0,0.1); 
        }
        
        /* Área do topo (Logo e Botão) */
        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            background: rgba(0,0,0,0.2);
        }
        
        .brand-name {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
            transition: opacity 0.2s;
        }

        /* O botão ☰ apenas com o ícone */
        .menu-btn { 
            cursor: pointer; 
            font-size: 22px; 
            color: white; 
            background: transparent;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
            padding: 5px;
            border-radius: 5px;
        }
        .menu-btn:hover { background: rgba(255,255,255,0.1); }

        .sidebar p.menu-label { padding: 15px 20px 5px; font-size: 12px; text-transform: uppercase; color: #94a3b8; font-weight: 600; margin: 0; transition: opacity 0.2s; }
        
        .sidebar a { 
            color: #cbd5e1; 
            text-decoration: none; 
            padding: 12px 20px; 
            font-size: 15px; 
            font-weight: 500; 
            transition: all 0.2s; 
            display: flex; 
            align-items: center; 
            gap: 12px; 
        }
        
        .sidebar a:hover { background-color: var(--dark-lighter); color: white; border-left: 4px solid var(--primary); padding-left: 16px; }
        
        /* === MENU LATERAL (FECHADO) === */
        /* A sidebar encolhe para 70px em vez de sumir */
        #menu-toggle:checked ~ .app-wrapper .sidebar { width: 70px; }
        
        /* Esconde os textos, deixando só os emojis visíveis */
        #menu-toggle:checked ~ .app-wrapper .sidebar .brand-name,
        #menu-toggle:checked ~ .app-wrapper .sidebar .menu-label,
        #menu-toggle:checked ~ .app-wrapper .sidebar a .link-text { 
            opacity: 0; 
            visibility: hidden; 
        }
        
        /* Centraliza o botão ☰ quando a barra fecha */
        #menu-toggle:checked ~ .app-wrapper .sidebar .sidebar-header {
            justify-content: center;
            padding: 20px 0;
        }

        .main-content { flex: 1; padding: 40px; box-sizing: border-box; background-color: var(--bg-color); min-width: 0;}
        
        /* Restante do CSS do painel... */
        .cabecalho-pagina { margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
        .cabecalho-pagina h1 { margin: 0; color: var(--dark); font-size: 28px; font-weight: 700; }
        .cabecalho-pagina p { margin: 5px 0 0 0; color: var(--text-muted); font-size: 15px; }
        .card { background: var(--card-bg); border-radius: 12px; padding: 25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03); border: 1px solid var(--border); margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 14px 16px; text-align: left; border-bottom: 1px solid var(--border); }
        th { background-color: #f1f5f9; font-weight: 600; color: var(--text-muted); font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; }
        tr:hover td { background-color: #f8fafc; }
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 13px; font-weight: 600; display: inline-block; }
        .risco-alto { background-color: #fee2e2; color: #b91c1c; }
        .risco-medio { background-color: #fef3c7; color: #b45309; }
        .risco-baixo { background-color: #dcfce7; color: #15803d; }
        .btn { display: inline-flex; align-items: center; justify-content: center; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; border: none; cursor: pointer; transition: all 0.2s; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-hover); transform: translateY(-1px); box-shadow: 0 4px 6px rgba(79, 70, 229, 0.2); }
        .btn-red { background: var(--danger); color: white; }
        .btn-red:hover { background: var(--danger-hover); transform: translateY(-1px); box-shadow: 0 4px 6px rgba(239, 68, 68, 0.2); }
        .btn-outline { background: white; color: var(--text-main); border: 1px solid var(--border); }
        .btn-outline:hover { background: #f1f5f9; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--dark); }
        input, select, textarea { width: 100%; padding: 12px 15px; border: 1px solid var(--border); border-radius: 8px; font-family: 'Inter', sans-serif; font-size: 15px; transition: border-color 0.2s; box-sizing: border-box; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 25px; font-weight: 500; display: flex; align-items: center; }
        .alert-success { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    </style>
</head>
<body>

<input type="checkbox" id="menu-toggle">

<div class="app-wrapper">
    <div class="sidebar">
        <div class="sidebar-header">
            <span class="brand-name">EduTech</span>
            <!-- Botão agora fica AQUI DENTRO, sem texto, só o ☰ -->
            <label for="menu-toggle" class="menu-btn" title="Recolher/Expandir Menu">☰</label>
        </div>
        
        <p class="menu-label">Administração</p>
        <a href="index.php?acao=dashboard" title="Monitoramento">
            <span class="icon">📊</span> <span class="link-text">Monitoramento</span>
        </a>
        <a href="index.php?acao=novo_aluno" title="Cadastrar Aluno">
            <span class="icon">➕</span> <span class="link-text">Cadastrar Aluno</span>
        </a>
        
        <p class="menu-label">Corpo Docente</p>
        <a href="index.php?acao=professor" title="Lançar Notas">
            <span class="icon">👨‍🏫</span> <span class="link-text">Lançar Notas</span>
        </a>
        
        <p class="menu-label">Visão dos Alunos</p>
        <a href="index.php?acao=aluno&id=1" title="Gabriel Kumagai">
            <span class="icon">🎓</span> <span class="link-text">Gabriel Kumagai</span>
        </a>
        <a href="index.php?acao=aluno&id=2" title="Ana Julia">
            <span class="icon">🎓</span> <span class="link-text">Ana Julia</span>
        </a>
    </div>

    <div class="main-content">
        <!-- O resto dos arquivos (dashboard, formulários) será renderizado automaticamente aqui dentro -->