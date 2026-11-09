<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>EduTech - Monitoramento Escolar</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        :root {
            --primary: #4f46e5; 
            --dark: #0f172a; 
            --dark-lighter: #1e293b;
            --bg-color: #f8fafc; 
            --card-bg: #ffffff;
            --text-main: #334155; 
            --text-muted: #64748b;
            --border: #e2e8f0;
            --danger: #ef4444; 
            --success: #10b981;
        }

        body { font-family: 'Inter', sans-serif; background-color: var(--bg-color); margin: 0; color: var(--text-main); }
        
        /* 1. O CHECKBOX INVISÍVEL QUE CONTROLA O MENU */
        #menu-toggle { display: none; }
        
        .app-wrapper { display: flex; width: 100%; min-height: 100vh; }
        
        /* === MENU LATERAL (ESTADO ABERTO) === */
        .sidebar { 
            width: 260px; 
            background-color: var(--dark); 
            color: white; 
            display: flex; 
            flex-direction: column; 
            transition: width 0.3s ease; 
            overflow: hidden; 
            white-space: nowrap; 
        }
        
        .sidebar-header {
            padding: 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        /* O BOTÃO QUE ABRE/FECHA (Disfarçado de botão Dashboard) */
        .menu-btn { 
            cursor: pointer; 
            color: white; 
            display: flex; 
            align-items: center; 
            gap: 15px;
            font-size: 16px;
            font-weight: 600;
            background-color: var(--primary);
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            transition: 0.2s;
        }
        .menu-btn:hover { background-color: #4338ca; }
        .menu-btn .icon { font-size: 20px; }

        /* A DIV COM OS OUTROS LINKS */
        .menu-items {
            display: flex;
            flex-direction: column;
            transition: opacity 0.2s ease, visibility 0.2s;
        }

        .sidebar p.menu-label { padding: 20px 20px 5px; font-size: 12px; text-transform: uppercase; color: #94a3b8; font-weight: 600; margin: 0;}
        
        .sidebar a { 
            color: #cbd5e1; 
            text-decoration: none; 
            padding: 12px 20px; 
            font-size: 15px; 
            font-weight: 500; 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            transition: all 0.2s; 
        }
        .sidebar a:hover { background-color: var(--dark-lighter); color: white; border-left: 4px solid var(--primary); padding-left: 16px; }
        
        /* === MENU LATERAL (ESTADO FECHADO) === */
        /* Reduz a largura do menu para caber só o ícone */
        #menu-toggle:checked ~ .app-wrapper .sidebar { width: 75px; }
        
        /* Esconde o texto da palavra "Dashboard" do botão */
        #menu-toggle:checked ~ .app-wrapper .menu-btn .link-text { display: none; }
        
        /* ESCONDE TODO O RESTO DO MENU (Links de professores, alunos, etc) */
        #menu-toggle:checked ~ .app-wrapper .menu-items { 
            opacity: 0; 
            visibility: hidden; 
            height: 0;
        }
        
        /* Centraliza o botão quando fechado */
        #menu-toggle:checked ~ .app-wrapper .sidebar-header { padding: 20px 15px; }

        /* === CONTEÚDO PRINCIPAL === */
        .main-content { flex: 1; padding: 40px; box-sizing: border-box; background-color: var(--bg-color); min-width: 0;}
        
        .cabecalho-pagina { margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
        .cabecalho-pagina h1 { margin: 0; color: var(--dark); font-size: 28px; font-weight: 700; }
        .cabecalho-pagina p { margin: 5px 0 0 0; color: var(--text-muted); font-size: 15px; }
        
        .card { background: var(--card-bg); border-radius: 12px; padding: 25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid var(--border); margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 14px 16px; text-align: left; border-bottom: 1px solid var(--border); }
        th { background-color: #f1f5f9; font-weight: 600; color: var(--text-muted); font-size: 14px; text-transform: uppercase; }
        tr:hover td { background-color: #f8fafc; }
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 13px; font-weight: 600; }
        .risco-alto { background-color: #fee2e2; color: #b91c1c; }
        .risco-medio { background-color: #fef3c7; color: #b45309; }
        .risco-baixo { background-color: #dcfce7; color: #15803d; }
        .btn { display: inline-flex; align-items: center; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; border: none; cursor: pointer; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-red { background: var(--danger); color: white; }
        .btn-outline { background: white; color: var(--text-main); border: 1px solid var(--border); }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--dark); }
        input, select, textarea { width: 100%; padding: 12px 15px; border: 1px solid var(--border); border-radius: 8px; font-family: 'Inter', sans-serif; font-size: 15px; box-sizing: border-box; }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 25px; display: flex; align-items: center; background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    </style>
</head>
<body>

<!-- 2. O CHECKBOX DEVE FICAR AQUI, LOGO APÓS O BODY -->
<input type="checkbox" id="menu-toggle">

<div class="app-wrapper">
    <div class="sidebar">
        
        <div class="sidebar-header">
            <!-- 3. O BOTÃO DE DASHBOARD QUE ABRE/FECHA A BARRA -->
            <label for="menu-toggle" class="menu-btn" title="Alternar Menu">
                <span class="icon">📊</span>
                <span class="link-text">Dashboard</span>
            </label>
        </div>
        
        <!-- 4. TODOS OS OUTROS ITENS SOMEM QUANDO FECHA -->
        <div class="menu-items">
            <a href="index.php?acao=dashboard"><span class="icon">📈</span> Monitoramento</a>
            <a href="index.php?acao=novo_aluno"><span class="icon">➕</span> Cadastrar Aluno</a>
            
            <p class="menu-label">Corpo Docente</p>
            <a href="index.php?acao=professor"><span class="icon">👨‍🏫</span> Lançar Notas</a>
            
            <p class="menu-label">Visão dos Alunos</p>
            <a href="index.php?acao=aluno&id=1"><span class="icon">🎓</span> Gabriel Kumagai</a>
            <a href="index.php?acao=aluno&id=2"><span class="icon">🎓</span> Ana Julia</a>
        </div>
        
    </div>

    <!-- O CONTEÚDO DA PÁGINA (Tabelas e Forms) SERÁ RENDERIZADO AQUI DENTRO -->
    <div class="main-content">